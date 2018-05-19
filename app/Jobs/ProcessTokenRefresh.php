<?php

namespace App\Jobs;

use App\Character;
use App\OAuth2Token;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTokenRefresh extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $character;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Character $character
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
     * @return void
     */
    public function handle()
    {
        /** @var OAuth2Token $token */
        $token = $this->character->token()->first();
        $curl = curl_init(self::EVE_AUTH_URL);
        curl_setopt_array($curl, [
            CURLOPT_USERAGENT => env('EVE_USERAGENT'),
            CURLOPT_HTTPHEADER => $this->getBasicAuthHeader(),
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token='.$token->refresh_token,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (!isset($response['access_token'])) {
            $this->fail();
        }

        $token->access_token = $response['access_token'];
        $token->refresh_token = $response['refresh_token'];
        $token->expires_on->addSeconds($response['expires_in']);
        $token->save();

        broadcast(new \App\Events\TokenRefreshed($this->user, $this->character));
    }
}
