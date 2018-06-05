<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Character;
use App\Jobs\Exceptions\ApiCharacterNotFound;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\OAuth2Token;
use Illuminate\Support\Carbon;

class AuthorizesAPI
{
    const EVE_AUTH_URL = 'https://login.eveonline.com/oauth/token';

    /**
     * Get the prepared header for Basic Authorization.
     *
     * @return string
     */
    protected function getBasicAuthHeader()
    {
        return 'Authorization: Basic '.base64_encode(env('EVE_CLIENT_ID').':'.env('EVE_SECRET'));
    }

    /**
     * @param $entity
     * @throws ApiCharacterNotFound
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
     * @throws InvalidApiResponse
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
     * @return bool
     */
    private function tokenNeedsRefresh(OAuth2Token $token)
    {
        return $token->expires_on->isPast();
    }

    /**
     * @param Character $character
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

        broadcast(new \App\Events\TokenRefreshed($character));
    }
}
