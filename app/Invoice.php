<?php

namespace App;

use App\Events\Invoice\ForcePaymentPosted;
use App\Events\Invoice\PaymentPosted;
use App\Traits\Commentable;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Invoice
 * @package App
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property int $recipient_id
 * @property string $recipient_type
 * @property string $code
 * @property string $title
 * @property string $status
 * @property double $total
 * @property Carbon $due_date
 * @property Carbon $hard_due_date
 */
class Invoice extends Model
{
    use Commentable, Notifiable, UuidTrait;

    const STATE_PENDING = 'pending';

    const STATE_FULFILLED = 'fulfilled';

    const STATE_OVERDUE = 'overdue';

    public $incrementing = false;

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
        'hard_due_date'
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->notifications()->whereIn('type', [PaymentPosted::class, ForcePaymentPosted::class]);
    }
}
