<?php

namespace App\Http\Controllers;

use App\Enum\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function index()
    {
        $records = Transaction::where('transaction_type', TransactionTypeEnum::DEPOSIT)->get();

        return view('deposit.index', compact('records'));
    }

    public function create()
    {
        $users = User::all();
        return view('deposit.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->message());

        Transaction::create([
            'transaction_type' => TransactionTypeEnum::DEPOSIT,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'date' => now(),
        ]);

        return redirect()->route('transaction.deposit.index')->with("success", "Deposit created successfully!");
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
