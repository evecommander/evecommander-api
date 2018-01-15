<?php

namespace App\Listeners;

use App\Events\Invoice\CommentPosted;
use App\Events\Invoice\Created;
use App\Events\Invoice\ForcePaymentPosted;
use App\Events\Invoice\Fulfilled;
use App\Events\Invoice\PaymentPosted;
use App\Events\Invoice\StateChanged;
use App\Events\Invoice\Updated;
use App\Notifications\Invoice\Created as CreatedNotification;
use App\Notifications\Invoice\Updated as UpdatedNotification;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Notification;

class InvoiceEventSubscriber
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Created::class, 'App\Listeners\InvoiceEventSubscriber@onCreated');

        $events->listen(Updated::class, 'App\Listeners\InvoiceEventSubscriber@onUpdated');

        $events->listen(Fulfilled::class, 'App\Listeners\InvoiceEventSubscriber@onFulfilled');

        $events->listen(StateChanged::class, 'App\Listeners\InvoiceEventSubscriber@onStateChanged');

        $events->listen(PaymentPosted::class, 'App\Listeners\InvoiceEventSubscriber@onPaymentPosted');

        $events->listen(ForcePaymentPosted::class, 'App\Listeners\InvoiceEventSubscriber@onForcePaymentPosted');

        $events->listen(CommentPosted::class, 'App\Listeners\InvoiceEventSubscriber@onCommentPosted');
    }

    public function onCreated($event)
    {
        $users = $event->invoice->recipient()->subscribers();

        Notification::send($users, new CreatedNotification($event->invoice));
    }

    public function onUpdated($event)
    {
        $users = $event->invoice->recipient()->subscribers();

        Notification::send($users, new UpdatedNotification($event->invoice));
    }

    public function onStateChanged($event)
    {

    }

    public function onPaymentPosted($event)
    {

    }

    public function onForcePaymentPosted($event)
    {

    }

    public function onFulfilled($event)
    {

    }

    public function onCommentPosted($event)
    {

    }
}