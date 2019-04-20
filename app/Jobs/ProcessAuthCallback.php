<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Alliance;
use App\Character;
use App\Corporation;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\Membership;
use App\MembershipLevel;
use App\OAuth2Token;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Swagger\Client\ApiException;

class ProcessAuthCallback extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $authorizationCode;

    /**
     * @var OAuth2Token
     */
    protected $token;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User   $user
     * @param string $authorizationCode
     *
     * @return void
     */
    public function __construct(User $user, string $authorizationCode)
    {
        $this->user = $user;
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * Execute the job.
     *
     * @throws ApiException
     * @throws InvalidApiResponse
     * @throws \Jose\Component\Checker\InvalidClaimException
     * @throws \Jose\Component\Checker\MissingMandatoryClaimException
     *
     * @return void
     */
    public function handle()
    {
        // verify the code and get an access token
        $response = $this->getAccessToken();

        $this->token = new OAuth2Token();
        $this->token->access_token = $response['access_token'];
        $this->token->refresh_token = $response['refresh_token'];
        $this->token->expires_on = Carbon::create()->addSeconds($response['expires_in']);

        $this->verifyJWT($this->token->access_token);

        // call api to get character information
        $response = $this->getCharacterID();

        $character = $this->getCharacterInformation($response['CharacterID']);

        $character->user()->associate($this->user);
        $this->token->character()->associate($character);

        $character->save();
        $this->token->save();

        broadcast(new \App\Events\CharacterAdded($this->user, $character));
    }

    /**
     * @throws InvalidApiResponse
     *
     * @return mixed
     */
    private function getAccessToken()
    {
        Log::debug('Getting access token');
        $curl = curl_init(static::EVE_AUTH_URL);
        $headers = $this->getBasicAuthHeader() + [
            'Content-Type: application/x-www-form-urlencoded',
            'Host: login.eveonline.com',
        ];

        $options = [
            CURLOPT_USERAGENT      => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => http_build_query([
                'grant_type' => 'authorization_code',
                'code'       => $this->authorizationCode,
            ]),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_VERBOSE        => true,
        ];

        curl_setopt_array($curl, $options);

        if (!$response = json_decode(curl_exec($curl), true)) {
            trigger_error(curl_error($curl));
        }

        $info = curl_getinfo($curl);
        curl_close($curl);

        Log::debug('Response from getting access token', [
            'response' => $response,
            'info'     => $info,
            'headers'  => $headers,
            'options'  => $options,
        ]);

        if (!isset($response['access_token'])) {
            throw new InvalidApiResponse();
        }

        return $response;
    }

    /**
     * @throws InvalidApiResponse
     *
     * @return array
     */
    private function getCharacterID()
    {
        Log::debug('Getting character ID');
        $curl = curl_init('https://esi.tech.ccp.is/verify/');
        curl_setopt_array($curl, [
            CURLOPT_USERAGENT      => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER     => 'Authorization: Bearer '.$this->token->access_token,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        if (!$response = json_decode(curl_exec($curl), true)) {
            trigger_error(curl_error($curl));
        }

        curl_close($curl);

        Log::debug('Response from getting character ID', $response);

        if (!isset($response['CharacterID'])) {
            throw new InvalidApiResponse();
        }

        return $response;
    }

    /**
     * @param $characterID
     *
     * @throws ApiException
     *
     * @return Character
     */
    private function getCharacterInformation($characterID)
    {
        $characterResponse = (new \Swagger\Client\Api\CharacterApi(null, $this->buildConfiguration()))
            ->getCharactersCharacterId($characterID);
        $character = new Character();
        $character->api_id = $characterID;
        $character->name = $characterResponse->getName();
        $corporation = $this->checkCorporation($characterResponse->getCorporationId());
        /** @var MembershipLevel $membershipLevel */
        $membershipLevel = $corporation->defaultMembershipLevel;
        $this->createMembership($corporation, $character, $membershipLevel);

        return $character;
    }

    /**
     * @param int $corporationID
     *
     * @throws ApiException
     *
     * @return Corporation
     */
    private function checkCorporation($corporationID)
    {
        try {
            $corporation = Corporation::where('api_id', $corporationID)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $corporation = new Corporation();
            $response = (new \Swagger\Client\Api\CorporationApi(null, $this->buildConfiguration()))
                ->getCorporationsCorporationId($corporationID);
            $corporation->api_id = $corporationID;
            $corporation->name = $response->getName();
            $corporation->save();

            $corpDefaultMembershipLevel = $this->createDefaultMembershipLevel($corporation);

            $corporation->defaultMembershipLevel()->associate($corpDefaultMembershipLevel);

            $alliance = $this->checkAlliance($response->getAllianceId());
            $this->createMembership($alliance, $corporation, $corpDefaultMembershipLevel);
        }

        return $corporation;
    }

    /**
     * @param Organization    $organization
     * @param Model           $member
     * @param MembershipLevel $membershipLevel
     *
     * @return Membership
     */
    private function createMembership(Organization $organization, Model $member, MembershipLevel $membershipLevel)
    {
        $membership = new Membership();
        $membership->notes = 'Auto-Generated by Eve Commander';
        $membership->organization()->associate($organization);
        $membership->member()->associate($member);
        $membership->membershipLevel()->associate($membershipLevel);
        $membership->save();

        return $membership;
    }

    /**
     * @param Organization $organization
     *
     * @return MembershipLevel
     */
    private function createDefaultMembershipLevel(Organization $organization)
    {
        $membershipLevel = new MembershipLevel();

        foreach (MembershipLevel::DEFAULT_DATA as $key => $value) {
            $membershipLevel->{$key} = $value;
        }

        $membershipLevel->organization()->associate($organization);
        $membershipLevel->save();

        return $membershipLevel;
    }

    /**
     * @param $allianceID
     *
     * @throws ApiException
     *
     * @return Alliance
     */
    private function checkAlliance($allianceID)
    {
        try {
            $alliance = Alliance::where('api_id', $allianceID)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $alliance = new Alliance();
            $response = (new \Swagger\Client\Api\AllianceApi(null, $this->buildConfiguration()))
                ->getAlliancesAllianceId($allianceID);
            $alliance->api_id = $allianceID;
            $alliance->name = $response->getName();
            $alliance->save();

            $allianceDefaultMembershipLevel = $this->createDefaultMembershipLevel($alliance);

            $alliance->defaultMembershipLevel()->associate($allianceDefaultMembershipLevel);
        }

        return $alliance;
    }
}
