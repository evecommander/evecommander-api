<?php

namespace App\Jobs;

use App\Abstracts\Organization;
use App\Character;
use App\Events\InvoiceUpdated;
use App\Invoice;
use App\Notifications\Invoice\StatusUpdatedIssuer;
use App\Notifications\Invoice\StatusUpdatedRecipient;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessInvoiceStatuses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $initialStatus;

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
        $this->initialStatus = $this->invoice->status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->isFulfilled()) {
            return;
        }

        $this->checkPayments();

        if ($this->isFulfilled()) {
            $this->sendNotification();

            return;
        }

        $this->checkDates();

        $this->sendNotification();
    }

    /**
     * Send a StatusChanged notification iif the status has changed.
     */
    protected function sendNotification()
    {
        if ($this->initialStatus !== $this->invoice->status) {
            // send status change notification to the recipient
            Notification::send(
                $this->getNotifiableModels($this->invoice->recipient, StatusUpdatedRecipient::class),
                new StatusUpdatedRecipient($this->invoice, $this->initialStatus)
            );

            // send status change notification to the issuer
            Notification::send(
                $this->getNotifiableModels($this->invoice->issuer, StatusUpdatedIssuer::class),
                new StatusUpdatedIssuer($this->invoice, $this->initialStatus)
            );

            // broadcast that the invoice has changed
            broadcast(new InvoiceUpdated($this->invoice));
        }
    }

    /**
     * Get notifiable models for the given entity.
     *
     * @param Model  $entity
     * @param string $notification
     *
     * @return array|\Illuminate\Support\Collection
     */
    protected function getNotifiableModels(Model $entity, string $notification)
    {
        if ($entity instanceof Character) {
            $entity->loadMissing('user');
            /* @var Character $entity */
            return collect([$entity->user]);
        } else {
            /** @var Organization $entity */
            $subscriptions = $entity->subscriptions()
                ->where(
                    'subscriptions.notification',
                    '=',
                    array_search($notification, Subscription::AVAILABLE_NOTIFICATIONS)
                )
                ->with('character.user')
                ->get();

            $notifiables = collect();

            $subscriptions->map(function (Subscription $subscription) use ($notifiables) {
                $notifiables->push($subscription->character->user);
            });

            return $notifiables->unique('id');
        }
    }

    /**
     * Return whether the invoice is marked as fulfilled.
     *
     * @return bool
     */
    protected function isFulfilled()
    {
        return $this->invoice->status === Invoice::STATE_FULFILLED;
    }

    /**
     * Check whether the last payment on the invoice cleared the remaining balance. If it has, update the status.
     */
    protected function checkPayments()
    {
        $lastPayment = $this->invoice->payments->first();

        if (!isset($lastPayment)) {
            return;
        }

        if ($lastPayment->data['balance_due'] <= 0) {
            $this->invoice->status = Invoice::STATE_FULFILLED;
            $this->invoice->save();
        }
    }

    /**
     * Check whether the invoice's due dates have been reached.
     */
    protected function checkDates()
    {
        if ($this->invoice->due_date->isPast()) {
            $this->invoice->status = Invoice::STATE_OVERDUE;
        }

        if ($this->invoice->hard_due_date->isPast()) {
            $this->invoice->status = Invoice::STATE_IN_DEFAULT;
        }

        $this->invoice->save();
    }
}
