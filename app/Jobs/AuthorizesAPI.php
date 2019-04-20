<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Character;
use App\Jobs\Exceptions\ApiCharacterNotFound;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\OAuth2Token;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\Checker\ClaimCheckerManager;
use Jose\Component\Checker\ExpirationTimeChecker;
use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Checker\IssuedAtChecker;
use Jose\Component\Checker\NotBeforeChecker;
use Jose\Component\Checker\Tests\Stub\IssuerChecker;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Core\JWKSet;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSLoader;
use Jose\Component\Signature\JWSTokenSupport;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Lcobucci\JWT\Signer\Key;
use Namshi\JOSE\Base64\Encoder;
use Namshi\JOSE\JWS;
use Namshi\JOSE\SimpleJWS;
use Swagger\Client\Configuration;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\Token;

class AuthorizesAPI
{
    const EVE_AUTH_URL = 'https://login.eveonline.com/v2/oauth/token';

    /**
     * @var OAuth2Token
     */
    protected $token;

    /**
     * @var User
     */
    protected $user;

    /**
     * Get the prepared header for Basic Authorization.
     *
     * @return array
     */
    protected function getBasicAuthHeader()
    {
        return ['Authorization: Basic '.base64_encode(env('EVE_CLIENT_ID').':'.env('EVE_SECRET'))];
    }

    /**
     * @return Configuration
     */
    protected function buildConfiguration()
    {
        return (new Configuration())->setAccessToken($this->token->access_token);
    }

    /**
     * @param $token
     * @return bool
     *
     * @throws \Exception
     * @throws \Jose\Component\Checker\InvalidClaimException
     * @throws \Jose\Component\Checker\MissingMandatoryClaimException
     */
    protected function verifyJWT($token)
    {
        // The JSON Converter.
        $jsonConverter = new StandardConverter();

        // The serializer manager. We only use the JWS Compact Serialization Mode.
        $serializerManager = JWSSerializerManager::create([
            new CompactSerializer($jsonConverter),
        ]);

        $headerCheckerManager = HeaderCheckerManager::create([
            new AlgorithmChecker(['RS256', 'ES256']),
            new IssuerChecker('login.eveonline.com')
        ], [
            new JWSTokenSupport(), // Adds JWS token type support
        ]);

        $claimCheckerManager = ClaimCheckerManager::create([
            new IssuedAtChecker(),
            new ExpirationTimeChecker(),
        ]);

        $jwks = Cache::get('eve_jwks', function () {
            return file_get_contents('https://login.eveonline.com/oauth/jwks');
        });

        $keySet = JWKSet::createFromJson($jwks);

        // The algorithm manager with the RS256 and ES256 algorithms.
        $algorithmManager = AlgorithmManager::create([
            new RS256(),
            new ES256(),
        ]);

        // We instantiate our JWS Verifier.
        $jwsVerifier = new JWSVerifier(
            $algorithmManager
        );

        $jwsLoader = new JWSLoader(
            $serializerManager,
            $jwsVerifier,
            $headerCheckerManager
        );

        $signature = null;
        $jws = $jwsLoader->loadAndVerifyWithKeySet($token, $keySet, $signature);

        $claimCheckerManager->check($jsonConverter->decode($jws->getPayload()));

        return true;
    }

    /**
     * @param $entity
     *
     * @throws ApiCharacterNotFound
     *
     * @return Character
     */
    protected function getApiCharacterForEntity($entity)
    {
        if ($entity instanceof Organization) {
            return Character::find($entity->settings['leader']);
        }

        if ($entity instanceof Character) {
            return $entity;
        }

        throw new ApiCharacterNotFound("Name: {$entity->name} Type: ".get_class($entity));
    }

    /**
     * @param Character $character
     *
     * @throws InvalidApiResponse
     *
     * @return OAuth2Token
     */
    protected function getCharacterToken(Character $character)
    {
        if ($this->tokenNeedsRefresh($character->token)) {
            $this->refreshToken($character);
        }

        return $character->token;
    }

    /**
     * @param OAuth2Token $token
     *
     * @return bool
     */
    private function tokenNeedsRefresh(OAuth2Token $token)
    {
        return $token->expires_on->isPast();
    }

    /**
     * @param Character $character
     *
     * @throws InvalidApiResponse
     */
    protected function refreshToken(Character $character)
    {
        $curl = curl_init(self::EVE_AUTH_URL);
        curl_setopt_array($curl, [
            CURLOPT_USERAGENT      => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER     => $this->getBasicAuthHeader(),
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => 'grant_type=refresh_token&refresh_token='.$character->token->refresh_token,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (!isset($response['access_token'])) {
            throw new InvalidApiResponse();
        }

        /** @var OAuth2Token $token */
        $token = $character->token;
        $token->expires_on = Carbon::create()->addSeconds($response['expires_in']);
        $token->access_token = $response['access_token'];
        $token->refresh_token = $response['refresh_token'];
        $token->save();

        broadcast(new \App\Events\TokenRefreshed($this->user, $character));
    }
}
