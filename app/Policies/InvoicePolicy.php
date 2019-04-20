<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Invoice;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class InvoicePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the invoice.
     *
     * @param User  $user
     * @param Model $invoice
     *
     * @return bool
     */
    public function read(User $user, Model $invoice): bool
    {
        /* @var Invoice $invoice */
        return $this->readRelationship($user, $invoice->issuer, 'invoices') ||
               $this->readRelationship($user, $invoice->recipient, 'invoices');
    }

    /**
     * Determine whether the user can create invoices.
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
        if (!$request->has('issuer_type') || !$request->has('issuer_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('issuer_type')::find($request->get('issuer_id'));

        return $this->modifyRelationship($user, $organization, 'invoices');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param User  $user
     * @param Model $invoice
     *
     * @return bool
     */
    public function update(User $user, Model $invoice): bool
    {
        /* @var Invoice $invoice */
        return $this->modifyRelationship($user, $invoice->issuer, 'invoices');
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param User  $user
     * @param Model $invoice
     *
     * @return bool
     */
    public function delete(User $user, Model $invoice): bool
    {
        /* @var Invoice $invoice */
        return $this->modifyRelationship($user, $invoice->issuer, 'invoices');
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readComments(User $user, Invoice $invoice): bool
    {
        return $this->read($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyComments(User $user, Invoice $invoice): bool
    {
        return $this->read($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readIssuer(User $user, Invoice $invoice): bool
    {
        return $user->can('read', [$invoice->issuer]);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyIssuer(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readRecipient(User $user, Invoice $invoice): bool
    {
        return $user->can('read', [$invoice->recipient]);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyRecipient(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readItems(User $user, Invoice $invoice): bool
    {
        return $this->read($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyItems(User $user, Invoice $invoice): bool
    {
        return $this->update($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readPayments(User $user, Invoice $invoice): bool
    {
        return $this->read($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyPayments(User $user, Invoice $invoice): bool
    {
        return $this->update($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readNotifications(User $user, Invoice $invoice): bool
    {
        return $this->read($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyNotifications(User $user, Invoice $invoice): bool
    {
        return $this->update($user, $invoice);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, Invoice $invoice): bool
    {
        return $user->can('read', [$invoice->lastUpdatedBy]);
    }

    /**
     * @param User    $user
     * @param Invoice $invoice
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
