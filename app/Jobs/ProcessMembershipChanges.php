<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Character;
use App\Coalition;
use App\Corporation;
use App\Jobs\Exceptions\ApiCharacterNotFound;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\Membership;
use App\Notifications\Membership\Created;
use App\Notifications\Membership\Deleted;
use App\Notifications\Membership\MembersUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Swagger\Client\Api\AllianceApi;
use Swagger\Client\Api\CorporationApi;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;

class ProcessMembershipChanges extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $organization;
    protected $configuration;
    protected $membersAdded = [];
    protected $membersRemoved = [];

    /**
     * Create a new job instance.
     *
     * @param Organization $organization
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     *
     * @throws ApiCharacterNotFound
     * @throws ApiException
     * @throws InvalidApiResponse
     * @return void
     */
    public function handle()
    {
        // this is not supported by coalitions as they are not defined in Eve Online
        if ($this->organization instanceof Coalition) {
            return;
        }

        $character = $this->getApiCharacterForEntity($this->organization);

        $this->configuration = (new Configuration())
            ->setAccessToken($this->getCharacterToken($character)->access_token)
            ->setUserAgent(env('EVE_USERAGENT'));

        $this->organization instanceof Corporation ? $this->handleCorporation() : $this->handleAlliance();
    }

    /**
     * Get current members for a corporation and hand off list to the diff engine.
     *
     * @throws ApiException
     */
    protected function handleCorporation()
    {
        $client = new CorporationApi(null, $this->configuration);
        $members = collect($client->getCorporationsCorporationIdMembers($this->organization->api_id));
        $this->diffMembers($members);
    }

    /**
     * Get current members for an alliance and hand off list to the diff engine.
     *
     * @throws ApiException
     */
    protected function handleAlliance()
    {
        $client = new AllianceApi(null, $this->configuration);
        $members = collect($client->getAlliancesAllianceIdCorporations($this->organization->api_id));
        $this->diffMembers($members);
    }

    /**
     * Differentiate between members in the database and those retrieved from the API.
     *
     * @param Collection $members
     */
    protected function diffMembers(Collection $members)
    {
        $currentMembers = $this->organization->members()->with('member')->get()->map(function (Membership $membership) {
            return $membership->member->api_id;
        });

        $this->addNewMembers($members->diff($currentMembers));
        $this->removeOldMembers($currentMembers->diff($members));

        $this->organization->notify(new MembersUpdated($this->organization, $this->membersAdded, $this->membersRemoved));
    }

    /**
     * Add new members to the organization.
     *
     * @param Collection $newMembers
     */
    protected function addNewMembers(Collection $newMembers)
    {
        // Only entities that are registered can be automatically added to membership
        if ($this->organization instanceof Corporation) {
            $membersToAdd = Character::whereIn('api_id', '=', $newMembers)->get();
        } else {
            $membersToAdd = Corporation::whereIn('api_id', '=', $newMembers)->get();
        }

        foreach ($membersToAdd as $memberToAdd) {
            $membership = new Membership();
            $membership->organization()->associate($this->organization);
            $membership->member()->associate($memberToAdd);
            $membership->membershipLevel()->associate($this->organization->defaultMembershipLevel);
            $membership->save();
            $membership->notify(new Created($membership));
            $this->membersAdded[] = $memberToAdd;
        }
    }

    /**
     * Remove old members from the organization.
     *
     * @param Collection $oldMembers
     */
    protected function removeOldMembers(Collection $oldMembers)
    {
        // Only entities that are registered can be automatically added to membership
        if ($this->organization instanceof Corporation) {
            $membersToRemove = Character::whereIn('api_id', '=', $oldMembers)->get();
        } else {
            $membersToRemove = Corporation::whereIn('api_id', '=', $oldMembers)->get();
        }

        $memberships = $this->organization->members()->whereHas('member', function (Builder $query) use ($membersToRemove) {
            $query->whereIn('api_id', $membersToRemove);
        })->get();

        foreach ($memberships as $membership) {
            $this->membersRemoved[] = $membership->member;
            $membership->notify(new Deleted($membership));
            $membership->delete();
        }
    }
}
