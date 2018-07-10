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

Broadcast::channel('App.User.{id}', function (\App\User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Character.{id}', function (\App\User $user, $id) {
    return $user->characters()->where('characters.id', '=', $id)->exists();
});

// Start Organization channels
Broadcast::channel('App.Corporation.{corporation}.Fleets', function (\App\User $user, \App\Corporation $corporation) {
    return $user->can('readRelationship', [$corporation, 'fleets', request()]);
});

Broadcast::channel('App.Alliance.{alliance}.Fleets', function (\App\User $user, \App\Alliance $alliance) {
    return $user->can('readRelationship', [$alliance, 'fleets', request()]);
});

Broadcast::channel('App.Coalition.{coalition}.Fleets', function (\App\User $user, \App\Coalition $coalition) {
    return $user->can('readRelationship', [$coalition, 'fleets', request()]);
});

Broadcast::channel('App.Corporation.{corporation}.Handbooks', function (\App\User $user, \App\Corporation $corporation) {
    return $user->can('readRelationship', [$corporation, 'handbooks', request()]);
});

Broadcast::channel('App.Alliance.{alliance}.Handbooks', function (\App\User $user, \App\Alliance $alliance) {
    return $user->can('readRelationship', [$alliance, 'handbooks', request()]);
});

Broadcast::channel('App.Coalition.{coalition}.Handbooks', function (\App\User $user, \App\Coalition $coalition) {
    return $user->can('readRelationship', [$coalition, 'handbooks', request()]);
});

Broadcast::channel('App.Corporation.{corporation}.Invoices', function (\App\User $user, \App\Corporation $corporation) {
    return $user->can('readRelationship', [$corporation, 'receivedInvoices', request()]);
});

Broadcast::channel('App.Alliance.{alliance}.Invoices', function (\App\User $user, \App\Alliance $alliance) {
    return $user->can('readRelationship', [$alliance, 'receivedInvoices', request()]);
});

Broadcast::channel('App.Coalition.{coalition}.Invoices', function (\App\User $user, \App\Coalition $coalition) {
    return $user->can('readRelationship', [$coalition, 'receivedInvoices', request()]);
});
// End Organization Channels

Broadcast::channel('App.Fleet.{fleet}', function (\App\User $user, \App\Fleet $fleet) {
    return $user->can('read', [$fleet, request()]);
});

Broadcast::channel('App.Handbook.{handbook}', function (\App\User $user, \App\Handbook $handbook) {
    return $user->can('read', [$handbook, request()]);
});

Broadcast::channel('App.Membership.{membership}', function (\App\User $user, \App\Membership $membership) {
    return $user->can('read', [$membership, request()]);
});

Broadcast::channel('App.ReplacementClaim.{replacementClaim}', function (\App\User $user, \App\ReplacementClaim $replacementClaim) {
    return $user->can('read', [$replacementClaim, request()]);
});

Broadcast::channel('App.Invoice.{invoice}', function (\App\User $user, \App\Invoice $invoice) {
    return $user->can('read', [$invoice, request()]);
});