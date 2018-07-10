<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Subscription.
 *
 * @property string id
 * @property string character_id
 * @property string organization_id
 * @property string organization_type
 * @property string notification
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Character character
 * @property Organization organization
 */
class Subscription extends Model
{
    use UuidTrait;

    const AVAILABLE_NOTIFICATIONS = [
        'fleet-created'           => Notifications\Fleet\Created::class,
        'handbook-created'        => Notifications\Handbook\Created::class,
        'handbook-updated'        => Notifications\Handbook\Updated::class,
        'invoice-payment'         => Notifications\Invoice\PaymentPosted::class,
        'invoice-comment'         => Notifications\Invoice\CommentPosted::class,
        'issued-invoice-status'   => Notifications\Invoice\StatusUpdatedIssuer::class,
        'received-invoice-status' => Notifications\Invoice\StatusUpdatedRecipient::class,
        'membership-comment'      => Notifications\Membership\CommentPosted::class,
        'membership-created'      => Notifications\Membership\Created::class,
        'members-updated'         => Notifications\Membership\MembersUpdated::class,
        'replacement-submitted'   => Notifications\ReplacementClaim\Submitted::class,
        'replacement-comment'     => Notifications\ReplacementClaim\CommentPosted::class,
    ];

    /**
     * Get the relation between this subscription and the character that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the relation between this subscription and the organization it points to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }
}
