<?php

namespace App\Listeners;

use App\Events\Membership\Join;
use App\Events\Membership\Leave;
use App\Events\Membership\Update;
use Illuminate\Events\Dispatcher;

class MembershipEventSubscriber
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Join::class, 'App\Listeners\MembershipEventSubscriber@onJoin');

        $events->listen(Leave::class, 'App\Listeners\MembershipEventSubscriber@onLeave');

        $events->listen(Update::class, 'App\Listeners\MembershipEventSubscriber@onUpdate');
    }

    public function onJoin()
    {

    }

    public function onLeave()
    {

    }

    public function onUpdate()
    {

    }
}