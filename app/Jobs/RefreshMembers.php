<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefreshMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // refresh members for corporations and alliances
        // Cycle through all corporations and alliances
        //     If a member has left, add to list of left members for notification email
        //         remove membership and add prorated invoice for the former member
        //     If a member has joined, add to list of added members for notification email
        //         add membership using default membership settings
        //
    }
}
