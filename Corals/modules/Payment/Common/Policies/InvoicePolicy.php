<?php

namespace Corals\Modules\Payment\Policies;

use Corals\User\Models\User;
use Corals\Modules\Payment\Models\Invoice;

class InvoicePolicy
{

    /**
     * @param User $user
     * @param Invoice|null $invoice
     * @return bool
     */
    public function view(User $user, Invoice $invoice = null)
    {
        if ($user->can('Payment::invoices.view_all')) {
            return true;
        }
        if ($user->can('Payment::invoices.view')) {
            if (($invoice->user->id == $user->id)) {
                return true;

            }

            if (isset($invoice->invoicable->generator) && $invoice->invoicable->generator->id == $user->id) {
                return true;
            }

        }


        return false;

    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Payment::invoices.create');
    }

    /**
     * @param User $user
     * @param Invoice $invoice
     * @return bool
     */
    public function update(User $user, Invoice $invoice)
    {
        if ($user->can('Payment::invoices.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Invoice $invoice
     * @return bool
     */
    public function destroy(User $user, Invoice $invoice)
    {
        if ($user->can('Payment::invoices.delete')) {
            return true;
        }
        return false;
    }


    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->hasPermissionTo('Administrations::admin.payment')) {
            return true;
        }

        return null;
    }
}
