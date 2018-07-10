<?php

namespace App\Observers;

use App\Character;
use App\Comment;
use App\Events\CommentAdded;
use App\Events\CommentDeleted;
use App\Events\CommentUpdated;
use App\Invoice;
use App\Membership;
use App\Notifications\Invoice\CommentPosted;
use App\ReplacementClaim;
use App\Subscription;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    /**
     * Handle to the comment "created" event.
     *
     * @param \App\Comment $comment
     *
     * @return void
     */
    public function created(Comment $comment)
    {
        $notifiables = collect();
        $notification = null;
        switch ($comment->commentable_type) {
            case Invoice::class:
                /** @var Invoice $invoice */
                $invoice = $comment->commentable;
                $notification = new CommentPosted($invoice, $comment);
                if ($comment->character_id === $invoice->recipient_id) {
                    // send notification to characters subscribed to the event on the invoice issuer
                    $notifiables = $invoice->issuer
                        ->subscriptions()
                        ->where('subscriptions.notification',
                            '=',
                            array_search(CommentPosted::class, Subscription::AVAILABLE_NOTIFICATIONS))
                        ->with('character.user')
                        ->get()
                        ->map(function (Subscription $item) use ($invoice, $comment) {
                            return $item->character->user;
                        });
                    break;
                }

                if ($invoice->recipient_type !== Character::class) {
                    // send notification to characters subscribed to the event on the invoice issuer
                    $notifiables = $invoice->recipient
                        ->subscriptions()
                        ->where('subscriptions.notification',
                            '=',
                            array_search(CommentPosted::class, Subscription::AVAILABLE_NOTIFICATIONS))
                        ->with('character.user')
                        ->get()
                        ->map(function (Subscription $item) use ($invoice, $comment) {
                            return $item->character->user;
                        });
                    break;
                }

                // send notification to the recipient of the invoice
                /** @var Character $recipient */
                $recipient = $invoice->recipient;

                $notifiables = collect($recipient->user);
                break;

            case Membership::class:
                /** @var Membership $membership */
                $membership = $comment->commentable;
                $notification = new \App\Notifications\Membership\CommentPosted($membership, $comment);
                if ($comment->character_id === $membership->member_id) {
                    // send notification to characters subscribed to the event on the membership's organization
                    $notifiables = $membership->organization
                        ->subscriptions()
                        ->where(
                            'subscriptions.notification',
                            '=',
                            array_search(\App\Notifications\Membership\CommentPosted::class, Subscription::AVAILABLE_NOTIFICATIONS)
                        )
                        ->with('character.user')
                        ->get()
                        ->map(function (Subscription $item) use ($membership, $comment) {
                            return $item->character->user;
                        });
                    break;
                }

                if ($membership->member_type !== Character::class) {
                    // send notification to characters subscribed to the event on the membership's member
                    $notifiables = $membership->member
                        ->subscriptions()
                        ->where(
                            'subscriptions.notification',
                            '=',
                            array_search(\App\Notifications\Membership\CommentPosted::class, Subscription::AVAILABLE_NOTIFICATIONS)
                        )
                        ->with('character.user')
                        ->get()
                        ->map(function (Subscription $item) use ($membership, $comment) {
                            return $item->character->user;
                        });
                    break;
                }

                // send notification to the member of the membership
                /** @var Character $member */
                $member = $membership->member;

                $notifiables = collect($member->user);
                break;

            case ReplacementClaim::class:
                /** @var ReplacementClaim $replacementClaim */
                $replacementClaim = $comment->commentable;
                $notification = new \App\Notifications\ReplacementClaim\CommentPosted($replacementClaim, $comment);
                if ($comment->character_id === $replacementClaim->character_id) {
                    // send notification to characters subscribed to the event on the replacement claim's organization
                    $notifiables = $replacementClaim->organization
                        ->subscriptions()
                        ->where(
                            'subscriptions.notification',
                            '=',
                            array_search(\App\Notifications\ReplacementClaim\CommentPosted::class, Subscription::AVAILABLE_NOTIFICATIONS)
                        )
                        ->with('character.user')
                        ->get()
                        ->map(function (Subscription $item) use ($replacementClaim, $comment) {
                            return $item->character->user;
                        });
                    break;
                }

                // send notification to the character attached to the replacement claim
                $notifiables = collect($replacementClaim->character->user);
        }

        if (!is_null($notification)) {
            Notification::send($notifiables, $notification);
        }

        broadcast(new CommentAdded($comment));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param \App\Comment $comment
     *
     * @return void
     */
    public function updated(Comment $comment)
    {
        broadcast(new CommentUpdated($comment));
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param \App\Comment $comment
     *
     * @return void
     */
    public function deleted(Comment $comment)
    {
        broadcast(new CommentDeleted($comment));
    }
}
