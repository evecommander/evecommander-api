<?php

namespace App\Abstracts;

use App\Character;
use App\FleetType;
use App\Role;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\IsMember;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Organization.
 *
 * @property array settings
 */
abstract class Organization extends Model
{
    use HasHandbooks, HasMembers, IsMember;

    /**
     * Get relation between this organization and any roles it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function roles()
    {
        return $this->morphMany(Role::class, 'owner');
    }

    /**
     * Get relation between this organization and any fleet types it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleetTypes()
    {
        return $this->morphMany(FleetType::class, 'owner');
    }

    /**
     * Get collection of all subscribers to invoice events on events that list this organization as the issuer.
     *
     * @return Collection
     */
    public function getIssuedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings['invoices']['issued']['subscribers'];

        $subscribers = Character::find($subscriberIds);

        // normalize single result case
        if ($subscribers instanceof Character) {
            $subscribers = collect($subscribers);
        }

        return $subscribers;
    }

    /**
     * Get collection of all subscribers to invoice events on events that list this organization as the recipient.
     *
     * @return Collection
     */
    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings['invoices']['received']['subscribers'];

        $subscribers = Character::find($subscriberIds);

        // normalize single result case
        if ($subscribers instanceof Character) {
            $subscribers = collect($subscribers);
        }

        return $subscribers;
    }
}
