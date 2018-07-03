<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use Illuminate\Http\Request;

trait AuthorizesInvoicesRelation
{
    /**
     * @param Organization $organization
     * @param Request $request
     * @return bool
     */
    public function readFulfilledInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'invoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyFulfilledInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request $request
     * @return bool
     */
    public function readOverdueInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'invoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyOverdueInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request $request
     * @return bool
     */
    public function readPendingInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'invoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyPendingInvoices()
    {
        return false;
    }

    /**
     * @param Organization $organization
     * @param Request $request
     * @return bool
     */
    public function readDefaultInvoices(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'invoices', 'read', $request);
    }

    /**
     * @return bool
     */
    public function modifyDefaultInvoices()
    {
        return false;
    }
}