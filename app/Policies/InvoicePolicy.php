<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Http\Middleware\CheckCharacter;
use App\Invoice;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InvoicePolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the invoice.
     *
     * @param User    $user
     * @param Model   $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $invoice, Request $request): bool
    {
        /* @var Invoice $invoice */
        return $this->authorizeRelation($invoice->issuer, 'invoices', 'read', $request) ||
            $this->authorizeRelation($invoice->recipient, 'invoices', 'read', $request) ||
            $invoice->recipient_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('issuer_type') || !$request->has('issuer_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('issuer_type')::find($request->get('issuer_id'));

        return $this->authorizeRelation($organization, 'invoices', 'modify', $request);
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param User    $user
     * @param Model   $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $invoice, Request $request): bool
    {
        /* @var Invoice $invoice */
        return $this->authorizeRelation($invoice->issuer, 'invoices', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param User    $user
     * @param Model   $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $invoice, Request $request): bool
    {
        /* @var Invoice $invoice */
        return $this->authorizeRelation($invoice->issuer, 'invoices', 'modify', $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readComments(Invoice $invoice, Request $request): bool
    {
        return $this->read($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyComments(Invoice $invoice, Request $request): bool
    {
        return $this->read($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readIssuer(Invoice $invoice, Request $request): bool
    {
        return $request->user()->can('read', [$invoice->issuer, $request]);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyIssuer(Invoice $invoice, Request $request): bool
    {
        return false;
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readRecipient(Invoice $invoice, Request $request): bool
    {
        return $request->user()->can('read', [$invoice->recipient, $request]);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyRecipient(Invoice $invoice, Request $request): bool
    {
        return false;
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readItems(Invoice $invoice, Request $request): bool
    {
        return $this->read($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyItems(Invoice $invoice, Request $request): bool
    {
        return $this->update($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readPayments(Invoice $invoice, Request $request): bool
    {
        return $this->read($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyPayments(Invoice $invoice, Request $request): bool
    {
        return $this->update($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->read($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->update($request->user(), $invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readReadNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->readNotifications($invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyReadNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->modifyNotifications($invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function readUnreadNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->readNotifications($invoice, $request);
    }

    /**
     * @param Invoice $invoice
     * @param Request $request
     *
     * @return bool
     */
    public function modifyUnreadNotifications(Invoice $invoice, Request $request): bool
    {
        return $this->modifyNotifications($invoice, $request);
    }
}
