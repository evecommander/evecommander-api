<?php

namespace App\Jobs;

use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class QueueFleetRefreshes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Collection $activeFleets */
        $activeFleets = Fleet::whereIn('status', [
            Fleet::STATUS_PENDING,
            Fleet::STATUS_STANDBY,
            Fleet::STATUS_FORM_UP,
            Fleet::STATUS_IN_PROGRESS,
        ])->has('trackerCharacter')->get();

        $activeFleets->map(function (Fleet $fleet) {
            RefreshFleet::dispatch($fleet);
        });
    }
}
