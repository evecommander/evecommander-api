<?php

namespace App\Jobs;

use App\Fleet;
use App\Squad;
use App\Wing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Swagger\Client\Api\FleetsApi;
use Swagger\Client\Model\GetFleetsFleetIdWings200Ok;
use Swagger\Client\Model\GetFleetsFleetIdWingsSquad;

class RefreshFleet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Fleet
     */
    public $fleet;

    /**
     * @var Collection
     */
    private $wingsToDelete;

    /**
     * @var Collection
     */
    private $squadsToDelete;

    /**
     * @var Collection
     */
    private $allCurrentSquads;

    /**
     * @var Collection
     */
    private $allNewSquads;

    /**
     * Create a new job instance.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function __construct(Fleet $fleet)
    {
        $this->fleet = $fleet->loadMissing('wings.squads');
        $this->wingsToDelete = collect();
        $this->squadsToDelete = collect();
        $this->allCurrentSquads = collect();
        $this->allNewSquads = collect();
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
        $newWings = collect((new FleetsApi())->getFleetsFleetIdWings($this->fleet->api_id))->keyBy('id');
        $currentWings = $this->fleet->wings->keyBy('api_id');

        // Mark wings for deletion if they are in $currentWings but not $newWings
        $this->wingsToDelete = $currentWings->filter(function (Wing $wing, $key) use ($newWings) {
            $this->allCurrentSquads += $wing->squads->keyBy('api_id');

            return !isset($newWings[$key]);
        });

        $this->updateWings($newWings, $currentWings);

        // Mark squads for deletion if they are in $this->allCurrentSquads but not in $this->allNewSquads
        $this->squadsToDelete += $this->allCurrentSquads->filter(function (Squad $squad, $key) {
            return !isset($this->allNewSquads[$key]);
        });

        $this->deleteOldWings();

        $this->deleteOldSquads();
    }

    /**
     * Update current wings to reflect the current data.
     *
     * @param Collection $new
     * @param Collection $current
     */
    private function updateWings(Collection $new, Collection $current)
    {
        /** @var GetFleetsFleetIdWings200Ok $newWing */
        foreach ($new as $wingApiID => $newWing) {
            /** @var Wing $wing */
            $wing = isset($current[$wingApiID]) ? $current[$wingApiID] : new Wing();

            $wing->api_id = $newWing->getId();
            $wing->name = $newWing->getName();
            $wing->fleet()->associate($this->fleet);

            // call restore to make sure the model is not soft deleted
            $wing->restore();

            $newWingSquads = collect($newWing->getSquads())->keyBy('id');
            $currentWingSquads = $wing->squads->keyBy('api_id');

            $this->updateSquads($wing, $newWingSquads, $currentWingSquads);
        }
    }

    /**
     * Update current squads in a wing to reflect the current data.
     *
     * @param Wing       $wing
     * @param Collection $new
     * @param Collection $current
     */
    private function updateSquads(Wing $wing, Collection $new, Collection $current)
    {
        /** @var GetFleetsFleetIdWingsSquad $newSquad */
        foreach ($new as $newSquad) {
            /** @var Squad $squad */
            $squad = isset($current[$newSquad->getId()]) ? $current[$newSquad->getId()] : new Squad();

            $squad->api_id = $newSquad->getId();
            $squad->name = $newSquad->getName();
            $squad->wing()->associate($wing);

            // call restore to make sure the model is not soft deleted
            $squad->restore();
        }
    }

    /**
     * Delete any wings that are no longer a part of the fleet.
     *
     * @throws \Exception
     */
    private function deleteOldWings()
    {
        /** @var Wing $wingToDelete */
        foreach ($this->wingsToDelete as $wingToDelete) {
            $wingToDelete->delete();
        }
    }

    /**
     * Delete any squads that are no longer a part of the fleet.
     *
     * @throws \Exception
     */
    private function deleteOldSquads()
    {
        /** @var Squad $squadToDelete */
        foreach ($this->squadsToDelete as $squadToDelete) {
            $squadToDelete->delete();
        }
    }
}
