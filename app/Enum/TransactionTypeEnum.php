<?php
namespace App\Enum;

enum TransactionTypeEnum:string{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
}
