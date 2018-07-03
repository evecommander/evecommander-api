<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\InvoiceItem;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InvoiceItemPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the invoice item.
     *
     * @param  User    $user
     * @param  Model   $invoiceItem
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $invoiceItem, Request $request): bool
    {
        /** @var InvoiceItem $invoiceItem */
        return $this->authorizeRelation($invoiceItem->invoice, 'invoice_items', 'read', $request);
    }

    /**
     * Determine whether the user can create invoice items.
     *
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        return $this->authorizeRelation($organization, 'fleets', 'modify', $request);
    }

    /**
     * Determine whether the user can update the invoice item.
     *
     * @param  User    $user
     * @param  Model   $invoiceItem
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $invoiceItem, Request $request): bool
    {
        /** @var InvoiceItem $invoiceItem */
        return $this->authorizeRelation($invoiceItem->invoice, 'invoice_items', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the invoice item.
     *
     * @param  User    $user
     * @param  Model   $invoiceItem
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $invoiceItem, Request $request): bool
    {
        /** @var InvoiceItem $invoiceItem */
        return $this->authorizeRelation($invoiceItem->invoice, 'invoice_items', 'modify', $request);
    }

    /**
     * @param InvoiceItem $invoiceItem
     * @param Request $request
     * @return bool
     */
    public function readInvoice(InvoiceItem $invoiceItem, Request $request): bool
    {
        $invoiceItem->loadMissing('invoice.issuer');

        return $request->user()->can('read', [$invoiceItem->invoice->issuer, $request]) ||
            $request->user()->can('read', [$invoiceItem->invoice->recipient, $request]) ||
            $invoiceItem->invoice->recipient_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * @param InvoiceItem $invoiceItem
     * @param Request $request
     * @return bool
     */
    public function modifyInvoice(InvoiceItem $invoiceItem, Request $request): bool
    {
        return false;
    }
}
