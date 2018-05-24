<?php

namespace App;

use App\Notifications\Invoice\Fulfilled;
use App\Notifications\Invoice\Issued;
use App\Notifications\Invoice\PaymentPosted;
use App\Notifications\Invoice\Updated;
use App\Traits\BubblesNotifications;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class Invoice.
 *
 * @property string id
 * @property string issuer_id
 * @property string issuer_type
 * @property string recipient_id
 * @property string recipient_type
 * @property string code
 * @property string title
 * @property string status
 * @property float total
 * @property Carbon due_date
 * @property Carbon hard_due_date
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection issuer
 * @property \Illuminate\Database\Eloquent\Collection recipient
 * @property \Illuminate\Database\Eloquent\Collection items
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection payments
 */
class Invoice extends Model
{
    use UuidTrait, HasComments, Notifiable, BubblesNotifications;

    const STATE_PENDING = 'pending';

    const STATE_FULFILLED = 'fulfilled';

    const STATE_OVERDUE = 'overdue';

    const STATE_IN_DEFAULT = 'default';

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
        'hard_due_date',
    ];

    protected function getBubbleToModels(Notification $notification)
    {
        // when an invoice is issued or updated, we only want to alert the recipient
        if ($notification instanceof Issued || $notification instanceof Updated) {
            return $this->recipient;
        }

        // when an invoice is fulfilled, we only want to alert the issuer
        if ($notification instanceof Fulfilled) {
            return $this->issuer;
        }

        // otherwise we want to alert both the issuer and recipient
        return $this->issuer->merge($this->recipient);
    }

    /**
     * Get the issuer of the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function issuer()
    {
        return $this->morphTo();
    }

    /**
     * Get the recipient of the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function recipient()
    {
        return $this->morphTo();
    }

    /**
     * Get any invoice items attached to the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get any payments posted for the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments()
    {
        return $this->notifications()->where('type', PaymentPosted::class);
    }

    /**
     * Get the amount still owed on the invoice.
     *
     * @return float
     */
    public function currentTotal()
    {
        $payments = $this->payments()->get('amount');

        return $this->total - $payments;
    }
}
