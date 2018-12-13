<?php

namespace App\Jobs;

use App\Character;
use App\Fleet;
use App\FleetMember;
use App\Squad;
use App\Wing;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Swagger\Client\Api\FleetsApi;
use Swagger\Client\Model\GetFleetsFleetIdMembers200Ok;

class RefreshFleetMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Fleet $fleet
     */
    public $fleet;

    public $currentMembers;

    public $newMembers;

    public $membersToDelete;

    /**
     * Create a new job instance.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function __construct(Fleet $fleet)
    {
        $this->fleet = $fleet;
        $this->currentMembers = collect();
        $this->newMembers = collect();
        $this->membersToDelete = collect();
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     * @throws \Swagger\Client\ApiException
     *
     * @return void
     */
    public function handle()
    {
        $currentMembers = $this->fleet->members()->get()->keyBy('character_api_id');
        $newMembers = collect((new FleetsApi())->getFleetsFleetIdMembers($this->fleet->api_id))
            ->keyBy('character_id');

        // Mark members for deletion if they are in $currentMembers but not $newMembers
        $this->membersToDelete = $currentMembers->filter(function (FleetMember $member, $key) use ($newMembers) {
            return !isset($newMembers[$key]);
        });

        $this->updateMembers($newMembers, $currentMembers);

        $this->deleteOldMembers();
    }

    /**
     * Update current members to reflect the current data.
     *
     * @param Collection $new
     * @param Collection $current
     */
    public function updateMembers(Collection $new, Collection $current)
    {
        /** @var GetFleetsFleetIdMembers200Ok $newMember */
        foreach ($new as $characterApiID => $newMember) {
            /** @var FleetMember $fleetMember */
            $fleetMember = isset($current[$characterApiID]) ? $current[$characterApiID] : new FleetMember;
            $fleetMember->character_api_id = $newMember->getCharacterId();
            $fleetMember->join_time = Carbon::create($newMember->getJoinTime());
            $fleetMember->role = $newMember->getRole();
            $fleetMember->ship_type_id = $newMember->getShipTypeId();
            $fleetMember->solar_system_id = $newMember->getSolarSystemId();
            $fleetMember->station_id = $newMember->getStationId();
            $fleetMember->takes_fleet_warp = $newMember->getTakesFleetWarp();

            $fleetMember->fleet()->associate($this->fleet);
            $fleetMember->wing()->associate(Wing::firstOrError(['api_id' => $newMember->getWingId()]));
            $fleetMember->squad()->associate(Squad::firstOrError(['api_id' => $newMember->getSquadId()]));

            /** @var Character|bool $character */
            if ($character = Character::first(['api_id' => $newMember->getCharacterId()])) {
                $fleetMember->character()->associate($character);
            }

            // call restore to make sure the model is not soft deleted
            $fleetMember->restore();
        }
    }

    /**
     * Delete any members that are no longer a part of the fleet.
     *
     * @throws \Exception
     */
    public function deleteOldMembers()
    {
        /** @var FleetMember $member */
        foreach ($this->membersToDelete as $member) {
            $member->delete();
        }
    }
}
