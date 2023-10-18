<?php

namespace App\Observers;

use App\Enum\AccountTypeEnum;
use App\Enum\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $transaction_type = $transaction->transaction_type;
        $user = User::find($transaction->user_id);

        //update the user balance
        if ($transaction_type == TransactionTypeEnum::DEPOSIT) {
            $user->balance = $user->balance + $transaction->amount;
        } else {
            $fee = $this->calculateFee($user, $transaction);
            $user->balance = $user->balance - ($fee + $transaction->amount);
            $transaction->fee = $fee;
            $transaction->save();
        }
        $user->save();
    }

    public function calculateFee($user, $transaction)
    {
        $withdraw_fee = 0;
        $withdraw_rate = $this->withdrawRate($user);
        $this_month_withdraw_amounts = $user->transactions(TransactionTypeEnum::WITHDRAWAL)
            ->whereMonth('date', date('m'))->get();

        $withdraw_limit_per_month = $this->checkWithdrawLimitPerMonth(5000, $this_month_withdraw_amounts);

        // calculate withdraw rate of current transaction

        if ($withdraw_rate != 0) {
            if (!$withdraw_limit_per_month) {
                $reduce_one_thousand_from_amount = $transaction->amount - 1000;

                if ($reduce_one_thousand_from_amount != 0) {
                    $withdraw_fee = ($withdraw_rate / 100) * $reduce_one_thousand_from_amount;
                }
            } else {
                $withdraw_fee = ($withdraw_rate / 100) * $transaction->amount;
            }
        }

        return $withdraw_fee;
    }

    public function checkWithdrawLimitPerMonth($limit, $this_month_withdraw_amounts)
    {
        $withdraw_count_per_month = 0;
        foreach ($this_month_withdraw_amounts as $record) {
            if ($record->amount >= 1000) {
                $withdraw_count_per_month += 1000;
            } else {
                $withdraw_count_per_month += $record->amount;
            }
        }

        // check 5k limit is over
        if ($withdraw_count_per_month >= $limit) {
            return true;
        }

        return false;
    }

    public function withdrawRate($user)
    {
        $rate = $user->account_type == AccountTypeEnum::BUSINESS ? 0.025 : 0.015;

        // if today is friday the set withdraw rate = 0
        if (strtolower(today()->format('l')) == "friday") {
            $rate = 0;
        }

        $total_withdraw = $this->get_user_withdraw_amount($user);

        if ($total_withdraw >= 50000) {
            $rate = 0.015;
        }

        return $rate;
    }

    public function get_user_withdraw_amount($user)
    {
        return $user->transactions(TransactionTypeEnum::WITHDRAWAL)->get()->sum('amount');
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
