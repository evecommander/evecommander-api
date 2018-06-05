<?php

namespace App\Policies;

use App\User;
use App\InvoiceItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoiceItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invoice item.
     *
     * @param  \App\User  $user
     * @param  \App\InvoiceItem  $invoiceItem
     * @return mixed
     */
    public function view(User $user, InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Determine whether the user can create invoice items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the invoice item.
     *
     * @param  \App\User  $user
     * @param  \App\InvoiceItem  $invoiceItem
     * @return mixed
     */
    public function update(User $user, InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Determine whether the user can delete the invoice item.
     *
     * @param  \App\User  $user
     * @param  \App\InvoiceItem  $invoiceItem
     * @return mixed
     */
    public function delete(User $user, InvoiceItem $invoiceItem)
    {
        //
    }
}
