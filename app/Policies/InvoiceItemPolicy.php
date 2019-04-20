<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\InvoiceItem;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the invoice item.
     *
     * @param User  $user
     * @param Model $invoiceItem
     *
     * @return bool
     */
    public function read(User $user, Model $invoiceItem): bool
    {
        /* @var InvoiceItem $invoiceItem */
        return $this->readRelationship($user, $invoiceItem->invoice, 'invoice_items');
    }

    /**
     * Determine whether the user can create invoice items.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->modifyRelationship($user, $organization, 'fleets');
    }

    /**
     * Determine whether the user can update the invoice item.
     *
     * @param User  $user
     * @param Model $invoiceItem
     *
     * @return bool
     */
    public function update(User $user, Model $invoiceItem): bool
    {
        /* @var InvoiceItem $invoiceItem */
        return $this->modifyRelationship($user, $invoiceItem->invoice, 'invoice_items');
    }

    /**
     * Determine whether the user can delete the invoice item.
     *
     * @param User  $user
     * @param Model $invoiceItem
     *
     * @return bool
     */
    public function delete(User $user, Model $invoiceItem): bool
    {
        /* @var InvoiceItem $invoiceItem */
        return $this->modifyRelationship($user, $invoiceItem->invoice, 'invoice_items');
    }

    /**
     * @param User        $user
     * @param InvoiceItem $invoiceItem
     *
     * @return bool
     */
    public function readInvoice(User $user, InvoiceItem $invoiceItem): bool
    {
        $invoiceItem->loadMissing('invoice.issuer');

        return $user->can('read', [$invoiceItem->invoice->issuer]) ||
               $user->can('read', [$invoiceItem->invoice->recipient]);
    }

    /**
     * @param User        $user
     * @param InvoiceItem $invoiceItem
     *
     * @return bool
     */
    public function modifyInvoice(User $user, InvoiceItem $invoiceItem): bool
    {
        return false;
    }
}
