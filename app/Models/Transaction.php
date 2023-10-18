<?php

namespace App\Models;

use App\Enum\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'transaction_type',
        'user_id',
        'amount',
        'fee',
        'date'
    ];

    protected $casts = [
        'transaction_type' => TransactionTypeEnum::class
    ];
}
