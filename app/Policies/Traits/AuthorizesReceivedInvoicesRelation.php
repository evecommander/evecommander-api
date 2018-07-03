<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use Illuminate\Http\Request;

trait AuthorizesReceivedInvoicesRelation
{
    /**
     * Determine whether the user can modify received invoices.
     *
     * @return bool
     */
    public function modifyReceivedInvoices()
    {
        return false;
    }

    // categories of received invoices

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return mixed
     */
    public function readFulfilledReceivedInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'receivedInvoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyFulfilledReceivedInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return mixed
     */
    public function readOverdueReceivedInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'receivedInvoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyOverdueReceivedInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return mixed
     */
    public function readPendingReceivedInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'receivedInvoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyPendingReceivedInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return mixed
     */
    public function readDefaultReceivedInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'receivedInvoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyDefaultReceivedInvoices()
    {
        return false;
    }
}
