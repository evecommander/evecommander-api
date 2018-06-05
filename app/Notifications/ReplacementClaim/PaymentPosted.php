<?php

namespace App\Notifications\ReplacementClaim;

use App\ReplacementClaim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PaymentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $claim;
    public $amount;
    public $transactionID;

    /**
     * Create a new notification instance.
     *
     * @param ReplacementClaim $claim
     * @param float            $amount
     * @param int              $transactionID
     *
     * @return void
     */
    public function __construct(ReplacementClaim $claim, float $amount, int $transactionID)
    {
        $this->claim = $claim;
        $this->amount = $amount;
        $this->transactionID = $transactionID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'claim_id'          => $this->claim->id,
            'character_id'      => $this->claim->character_id,
            'character_name'    => $this->claim->character->name,
            'organization_id'   => $this->claim->organization_id,
            'organization_type' => $this->claim->organization_type,
            'organization_name' => $this->claim->organization->name,
            'amount'            => $this->amount,
            'transaction_id'    => $this->transactionID,
        ];
    }
}
