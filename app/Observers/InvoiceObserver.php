<?php

namespace App\Observers;

use App\Abstracts\Organization;
use App\Character;
use App\Events\InvoiceReceived;
use App\Events\InvoiceUpdated;
use App\Http\Middleware\CheckCharacter;
use App\Invoice;
use App\InvoiceItem;
use App\Notifications\Invoice\Received;
use App\Notifications\Invoice\Updated;
use App\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class InvoiceObserver
{
    /**
     * Handle to the invoice "creating" event.
     *
     * @param Invoice $invoice
     *
     * @throws \Exception
     */
    public function creating(Invoice $invoice)
    {
        $this->calculateTotal($invoice);
        $invoice->due_date = Carbon::now()->add($invoice->issuer->dueDateInterval);
        $invoice->hard_due_date = Carbon::now()->add($invoice->issuer->hardDueDateInterval);
        $invoice->code = 'I-'.substr(bin2hex(random_bytes(16)), 0, 16);
    }

    /**
     * Set the total for the invoice from the items attached to it.
     *
     * @param Invoice $invoice
     *
     * @return void
     */
    protected function calculateTotal(Invoice $invoice)
    {
        $total = 0;

        /** @var InvoiceItem $item */
        foreach ($invoice->items()->get() as $item) {
            $total += $item->total;
        }

        $invoice->total = $total;
    }

    /**
     * Handle to the invoice "created" event.
     *
     * @param \App\Invoice $invoice
     *
     * @return void
     */
    public function created(Invoice $invoice)
    {
        Notification::send($this->getNotifiables($invoice->recipient), new Received($invoice));

        broadcast(new InvoiceReceived($invoice));
    }

    /**
     * Handle the invoice "updating" event.
     *
     * @param \App\Invoice $invoice
     *
     * @return void
     */
    public function updating(Invoice $invoice)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $invoice->lastUpdatedBy()->associate($character);

        // recalculate the total just in case items have shifted
        $this->calculateTotal($invoice);
    }

    /**
     * Handle the invoice "updated" event.
     *
     * @param \App\Invoice $invoice
     *
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        Notification::send($this->getNotifiables($invoice->recipient), new Updated($invoice));

        broadcast(new InvoiceUpdated($invoice));
    }

    /**
     * Get notifiable models for the notification.
     *
     * @param $recipient
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    private function getNotifiables($recipient)
    {
        if ($recipient instanceof Character) {
            $recipient->loadMissing('user');
            /* @var Character $recipient */
            return collect([$recipient, $recipient->user]);
        } else {
            /** @var Organization $recipient */
            $subscriptions = $recipient->subscriptions()
                ->where(
                    'subscriptions.notification',
                    '=',
                    array_search(Received::class, Subscription::AVAILABLE_NOTIFICATIONS)
                )
                ->with('character.user')
                ->get();

            return $subscriptions->map(function (Subscription $subscription) {
                return $subscription->character->user;
            });
        }
    }
}
