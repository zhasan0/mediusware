<?php

namespace App\Http\Controllers;

use App\Enum\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $records = Transaction::where('transaction_type', TransactionTypeEnum::WITHDRAWAL)->get();

        return view('withdrawal.index', compact('records'));
    }

    public function create()
    {
        $users = User::all();
        return view('withdrawal.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->message());

        Transaction::create([
            'transaction_type' => TransactionTypeEnum::WITHDRAWAL,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'date' => now(),
        ]);

        return redirect()->route('transaction.withdrawal.index')->with("success", "Withdrawal created successfully!");
    }

    public function rules()
    {
        return [
            "user_id" => "required",
            "amount" => "required",
        ];
    }

    public function message()
    {
        return [
            "user_id.required" => "User is required"
        ];
    }
}
