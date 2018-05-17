<?php

namespace App;

use App\Notifications\Invoice\ForcePaymentPosted;
use App\Notifications\Invoice\PaymentPosted;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Invoice.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
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
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany comments
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo issuer
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo recipient
 * @property \Illuminate\Database\Eloquent\Relations\HasMany items
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany notifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany readNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany unreadNotifications
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany payments
 */
class Invoice extends Model
{
    use UuidTrait, HasComments, Notifiable;

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
     * @return mixed
     */
    public function payments()
    {
        return $this->notifications()->whereIn('type', [PaymentPosted::class, ForcePaymentPosted::class]);
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
