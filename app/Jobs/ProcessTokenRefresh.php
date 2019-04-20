<?php

namespace App\Jobs;

use App\Character;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\User;
use CloudCreativity\LaravelJsonApi\Queue\ClientDispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTokenRefresh extends AuthorizesAPI implements ShouldQueue
{
    use ClientDispatchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $character;

    /**
     * Create a new job instance.
     *
     * @param User      $user
     * @param Character $character
     *
     * @return void
     */
    public function __construct(User $user, Character $character)
    {
        $this->user = $user;
        $this->character = $character;
    }

    /**
     * Execute the job.
     *
     * @throws InvalidApiResponse
     *
     * @return void
     */
    public function handle()
    {
        $this->refreshToken($this->character);
    }
}
