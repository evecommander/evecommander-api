<?php

namespace App\Jobs;

use App\Invoice;
use App\Jobs\Exceptions\ApiCharacterNotFound;
use App\Jobs\Exceptions\InvalidApiResponse;
use App\Notifications\Invoice\PaymentPosted;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Swagger\Client\Model\GetCharactersCharacterIdWalletJournal200Ok;

class ProcessInvoicePayments extends AuthorizesAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $continue = true;

    /**
     * Create a new job instance.
     *
     * @param Invoice $invoice
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @throws ApiCharacterNotFound
     * @throws ApiException
     * @throws InvalidApiResponse
     *
     * @return void
     */
    public function handle()
    {
        $character = $this->getApiCharacterForEntity($this->invoice->recipient);

        $config = (new Configuration())
            ->setAccessToken($this->getCharacterToken($character)->access_token)
            ->setUserAgent(env('EVE_USERAGENT'));

        $client = new \Swagger\Client\Api\WalletApi(null, $config);
        $page = 0;

        // look at past 2 days
        $lowerBound = Carbon::create()->subDays(2);

        while ($this->continue) {
            $page++;
            $journalEntries = $client->getCharactersCharacterIdWalletJournal($character->api_id, null, null, $page);

            $this->processJournalEntries($journalEntries, $lowerBound);
        }
    }

    /**
     * @param GetCharactersCharacterIdWalletJournal200Ok[] $entries
     * @param Carbon                                       $lowerBound
     */
    private function processJournalEntries($entries, Carbon $lowerBound)
    {
        foreach ($entries as $journalEntry) {
            if ($lowerBound->gt($journalEntry->getDate())) {
                $this->continue = false;
                continue;
            }

            if ($journalEntry->getSecondPartyId() !== $this->invoice->issuer->api_id) {
                continue;
            }

            if (str_contains($journalEntry->getReason(), $this->invoice->code)) {
                if (!$this->invoice->payments()->where('data->transaction_id', '=', $journalEntry->getId())->exists()) {
                    $this->invoice->notify(new PaymentPosted($this->invoice, $journalEntry->getAmount(), $journalEntry->getId()));
                }
            }
        }
    }
}
