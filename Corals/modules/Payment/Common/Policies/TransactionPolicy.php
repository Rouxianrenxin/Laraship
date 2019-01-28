<?php

namespace Corals\Modules\Payment\Policies;

use Corals\User\Models\User;
use Corals\Modules\Payment\Models\Transaction;

class TransactionPolicy
{

    /**
     * @param User $user
     * @param Transaction|null $transaction
     * @return bool
     */
    public function view(User $user, Transaction $transaction = null)
    {
        if ($user->can('Payment::transaction.view_all')) {
            return true;
        }
        if ($user->can('Payment::transaction.view')) {

            if (isset($transaction->owner) && $transaction->owner->id == $user->id) {
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
        return $user->can('Payment::transaction.create');
    }

    /**
     * @param User $user
     * @param Transaction $transaction
     * @return bool
     */
    public function update(User $user, Transaction $transaction)
    {
        if ($user->can('Payment::transaction.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Transaction $transaction
     * @return bool
     */
    public function destroy(User $user, Transaction $transaction)
    {
        if ($user->can('Payment::transaction.delete')) {
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
