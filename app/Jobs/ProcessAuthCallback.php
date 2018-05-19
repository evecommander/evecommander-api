<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Alliance;
use App\Character;
use App\Corporation;
use App\Membership;
use App\MembershipLevel;
use App\OAuth2Token;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Swagger\Client\ApiException;

class ProcessAuthCallback extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $authorizationCode;
    protected $user;
    protected $corporationID;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $authorizationCode
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
     * @return void
     */
    public function handle()
    {
        // verify the code and get an access token
        $response = $this->getAccessToken();

        $token = new OAuth2Token();
        $token->access_token = $response['access_token'];
        $token->refresh_token = $response['refresh_token'];
        $token->expires_on = Carbon::create()->addSeconds($response['expires_in']);

        // call api to get character information
        $response = $this->getCharacterID($token);

        try {
            $character = $this->getCharacterInformation($response['CharacterID']);
            $corporation = $this->checkCorporation();
            /** @var MembershipLevel $membershipLevel */
            $membershipLevel = $corporation->defaultMembershipLevel()->first();
            $this->createMembership($corporation, $character, $membershipLevel);
        } catch (ApiException $exception) {
            $this->fail();
            exit;
        }

        $character->user()->associate($this->user);
        $token->character()->associate($character);

        $character->save();
        $token->save();

        broadcast(new \App\Events\CharacterAdded($this->user, $character));
    }

    /**
     * @return mixed
     */
    private function getAccessToken()
    {
        $curl = curl_init(self::EVE_AUTH_URL);
        curl_setopt_array($curl, [
            CURLOPT_USERAGENT => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER => $this->getBasicAuthHeader(),
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code='.$this->authorizationCode,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (!isset($response['access_token'])) {
            $this->fail();
        }

        return $response;
    }

    /**
     * @param OAuth2Token $token
     */
    private function getCharacterID(OAuth2Token $token)
    {
        $curl = curl_init('https://esi.tech.ccp.is/verify/');
        curl_setopt_array($curl, [
            CURLOPT_USERAGENT => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER => 'Authorization: Bearer '.$token->access_token,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (!isset($response['CharacterID'])) {
            $this->fail();
        }
    }

    /**
     * @param $characterID
     * @return Character
     * @throws ApiException
     */
    private function getCharacterInformation($characterID)
    {
        $characterResponse = (new \Swagger\Client\Api\CharacterApi())
            ->getCharactersCharacterId($characterID, null, null, env('EVE_USERAGENT'));
        $character = new Character();
        $character->eve_id = $characterID;
        $character->name = $characterResponse->getName();
        $this->corporationID = $characterResponse->getCorporationId();

        return $character;
    }

    /**
     * @return Corporation
     * @throws ApiException
     */
    private function checkCorporation()
    {
        try {
            $corporation = Corporation::where('eve_id', $this->corporationID)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $corporation = new Corporation();
            $response = (new \Swagger\Client\Api\CorporationApi())
                ->getCorporationsCorporationId($this->corporationID, null, null, env('EVE_USERAGENT'));
            $corporation->api_id = $this->corporationID;
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
     * @param Organization $organization
     * @param Model $member
     * @param MembershipLevel $membershipLevel
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
     * @param Model $owner
     * @return MembershipLevel
     */
    private function createDefaultMembershipLevel(Model $owner)
    {
        $membershipLevel = new MembershipLevel();
        $membershipLevel->name = 'Default';
        $membershipLevel->description = 'Auto-Generated by Eve Commander';
        $membershipLevel->dues = 0.0;
        $membershipLevel->dues_structure = MembershipLevel::DUES_STRUCTURE_UPON_JOINING;
        $membershipLevel->owner()->associate($owner);
        $membershipLevel->save();

        return $membershipLevel;
    }

    /**
     * @param $allianceID
     * @return Alliance
     * @throws ApiException
     */
    private function checkAlliance($allianceID)
    {
        try {
            $alliance = Alliance::where('api_id', $allianceID)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $alliance = new Alliance();
            $response = (new \Swagger\Client\Api\AllianceApi())
                ->getAlliancesAllianceId($allianceID, null, null, env('EVE_USERAGENT'));
            $alliance->api_id = $allianceID;
            $alliance->name = $response->getName();
            $alliance->save();

            $allianceDefaultMembershipLevel = $this->createDefaultMembershipLevel($alliance);

            $alliance->defaultMembershipLevel()->associate($allianceDefaultMembershipLevel);
        }

        return $alliance;
    }
}
