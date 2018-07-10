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
     * @param  \App\Invoice  $invoice
     * @return void
     */
    public function creating(Invoice $invoice)
    {
        $this->calculateTotal($invoice);
        $this->setDueDate($invoice);
        $this->setHardDueDate($invoice);
        $invoice->code = 'I-'.substr(bin2hex(random_bytes(16)), 0, 16);
    }

    /**
     * Set the total for the invoice from the items attached to it.
     *
     * @param Invoice $invoice
     * @return void
     */
    protected function calculateTotal(Invoice $invoice)
    {
        $total = 0;

        /** @var InvoiceItem $item */
        foreach ($invoice->items as $item) {
            $total += ($item->cost * $item->quantity);
        }

        $invoice->total = $total;
    }

    /**
     * Set the due date for the invoice based on the issuer's settings.
     *
     * @param Invoice $invoice
     * @return void
     */
    protected function setDueDate(Invoice $invoice)
    {
        $issuerSettings = $invoice->issuer->settings;

        if (isset($issuerSettings['invoices']['due_date']['number']) && isset($issuerSettings['invoices']['due_date']['units'])) {
            $number = $issuerSettings['invoices']['due_date']['number'];
            $units = $issuerSettings['invoices']['due_date']['units'];
            switch ($units) {
                case 'days':
                    $invoice->due_date = Carbon::create()->addDays($number);
                    return;

                case 'weeks':
                    $invoice->due_date = Carbon::create()->addWeeks($number);
                    return;

                case 'months':
                    $invoice->due_date = Carbon::create()->addMonths($number);
                    return;
            }
        }

        // default is 2 weeks
        $invoice->due_date = Carbon::create()->addWeeks(2);
    }

    /**
     * Set the hard due date for the invoice based on the issuer's settings.
     *
     * @param Invoice $invoice
     * @return void
     */
    protected function setHardDueDate(Invoice $invoice)
    {
        $issuerSettings = $invoice->issuer->settings;

        if (isset($issuerSettings['invoices']['hard_due_date']['number']) &&
            isset($issuerSettings['invoices']['hard_due_date']['units'])) {
            $number = $issuerSettings['invoices']['hard_due_date']['number'];
            $units = $issuerSettings['invoices']['hard_due_date']['units'];
            switch ($units) {
                case 'days':
                    $invoice->hard_due_date = Carbon::create()->addDays($number);
                    return;

                case 'weeks':
                    $invoice->hard_due_date = Carbon::create()->addWeeks($number);
                    return;

                case 'months':
                    $invoice->hard_due_date = Carbon::create()->addMonths($number);
                    return;
            }
        }

        // default is 1 month
        $invoice->hard_due_date = Carbon::create()->addMonth();
    }

    /**
     * Handle to the invoice "created" event.
     *
     * @param  \App\Invoice  $invoice
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
     * @param  \App\Invoice  $invoice
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
     * @param  \App\Invoice  $invoice
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    private function getNotifiables($recipient)
    {
        if ($recipient instanceof Character) {
            $recipient->loadMissing('user');
            /** @var Character $recipient */
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
