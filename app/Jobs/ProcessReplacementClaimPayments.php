<?php

namespace App\Jobs;

use App\Jobs\Exceptions\InvalidApiResponse;
use App\Notifications\ReplacementClaim\PaymentPosted;
use App\ReplacementClaim;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Swagger\Client\Model\GetCharactersCharacterIdWalletJournal200Ok;

class ProcessReplacementClaimPayments extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $claim;
    protected $continue = true;

    /**
     * Create a new job instance.
     *
     * @param ReplacementClaim $claim
     *
     * @return void
     */
    public function __construct(ReplacementClaim $claim)
    {
        $this->claim = $claim;
    }

    /**
     * Execute the job.
     *
     * @throws ApiException
     * @throws InvalidApiResponse
     *
     * @return void
     */
    public function handle()
    {
        $config = (new Configuration())
            ->setAccessToken($this->getCharacterToken($this->claim->character)->access_token)
            ->setUserAgent(env('EVE_USERAGENT'));

        $client = new \Swagger\Client\Api\WalletApi(null, $config);
        $page = 0;

        // look at past 2 days
        $lowerBound = Carbon::create()->subDays(2);

        while ($this->continue) {
            $page++;
            $journalEntries = $client->getCharactersCharacterIdWalletJournal(
                $this->claim->character->api_id, null, null, $page
            );

            $this->processJournalEntries($journalEntries, $lowerBound);
        }
    }

    /**
     * Cycle through journal entries and check if any represent payments on replacement claims.
     *
     * @param GetCharactersCharacterIdWalletJournal200Ok[] $entries
     * @param Carbon                                       $lowerBound
     *
     * @return void
     */
    private function processJournalEntries($entries, Carbon $lowerBound)
    {
        foreach ($entries as $journalEntry) {
            if ($lowerBound->gt($journalEntry->getDate())) {
                $this->continue = false;
                continue;
            }

            if ($journalEntry->getSecondPartyId() !== $this->claim->organization->api_id) {
                continue;
            }

            if (str_contains($journalEntry->getReason(), $this->claim->code)) {
                if (!$this->claim->payments()->where('data->transaction_id', '=', $journalEntry->getId())->exists()) {
                    $this->claim->notify(new PaymentPosted($this->claim, $journalEntry->getAmount(), $journalEntry->getId()));
                }
            }
        }
    }
}
