<?php

namespace App\Jobs;

use App\Character;
use App\ReplacementClaim;
use Carbon\CarbonInterval;
use CloudCreativity\LaravelJsonApi\Queue\ClientDispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Swagger\Client\Api\KillmailsApi;
use Swagger\Client\Api\MarketApi;

class CreateReplacementClaim implements ShouldQueue
{
    use ClientDispatchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $character;

    protected $replacementClaim;

    /**
     * Create a new job instance.
     *
     * @param Character        $character
     * @param ReplacementClaim $replacementClaim
     */
    public function __construct(Character $character, ReplacementClaim $replacementClaim)
    {
        $this->character = $character;
        $this->replacementClaim = $replacementClaim;
    }

    /**
     * Execute the job.
     *
     * @throws \Swagger\Client\ApiException
     *
     * @return void
     */
    public function handle()
    {
        // get pricing from current market
        $killmail = (new KillmailsApi())
            ->getKillmailsKillmailIdKillmailHash($this->replacementClaim->killmail_hash, $this->replacementClaim->killmail_id);

        foreach ($killmail->getVictim()->getItems() as $item) {
            $itemType = $item->getItemTypeId();
            $quantity = $item->getQuantityDestroyed() + $item->getQuantityDropped();
            $marketValue = $this->getPriceForItemType($itemType);
        }
    }

    /**
     * @param int $itemTypeId
     *
     * @throws \Swagger\Client\ApiException
     *
     * @return mixed
     */
    protected function getPriceForItemType(int $itemTypeId)
    {
        if (!Cache::has("prices::{$itemTypeId}")) {
            $prices = (new MarketApi())->getMarketsPrices();

            foreach ($prices as $price) {
                Cache::put("prices::{$price['type_id']}", $price['average_price'], CarbonInterval::hour());
            }
        }

        return Cache::get("prices::{$itemTypeId}");
    }
}
