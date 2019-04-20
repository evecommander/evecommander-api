<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('/users/{user}', \App\Broadcasting\UserChannel::class);

Broadcast::channel('/characters/{character}', \App\Broadcasting\CharacterChannel::class);

// Start Organization channels
Broadcast::channel(
    '/organizations/{organization}',
    \App\Broadcasting\OrganizationChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/fleets',
    \App\Broadcasting\OrganizationFleetsChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/handbooks',
    \App\Broadcasting\OrganizationHandbooksChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/received-invoices',
    \App\Broadcasting\OrganizationReceivedInvoicesChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/issued-invoices',
    \App\Broadcasting\OrganizationIssuedInvoicesChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/replacement-claims',
    \App\Broadcasting\OrganizationReplacementClaimsChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/notifications',
    \App\Broadcasting\OrganizationNotificationsChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/discounts',
    \App\Broadcasting\OrganizationDiscountsChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/roles',
    \App\Broadcasting\OrganizationRolesChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/fleet-types',
    \App\Broadcasting\OrganizationFleetTypesChannel::class
);

Broadcast::channel(
    '/organizations/{organization}/subscriptions',
    \App\Broadcasting\OrganizationSubscriptionsChannel::class
);
// End Organization Channels

Broadcast::channel('/fleets/{fleet}', \App\Broadcasting\FleetChannel::class);

Broadcast::channel('/handbooks/{handbook}', \App\Broadcasting\HandbookChannel::class);

Broadcast::channel('/memberships/{membership}', \App\Broadcasting\MembershipChannel::class);

Broadcast::channel(
    '/replacement-claims/{replacementClaim}',
    \App\Broadcasting\ReplacementClaimChannel::class
);

Broadcast::channel('/invoices/{invoice}', \App\Broadcasting\InvoiceChannel::class);

Broadcast::channel('/comments/{comment}', \App\Broadcasting\CommentChannel::class);
