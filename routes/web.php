<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transaction.index');

        Route::group(['prefix' => 'deposit'], function () {
            Route::get('index', [DepositController::class, 'index'])->name('transaction.deposit.index');
            Route::get('create', [DepositController::class, 'create'])->name('transaction.deposit.create');
            Route::post('store', [DepositController::class, 'store'])->name('transaction.deposit.store');
        });

        Route::group(['prefix' => 'withdrawal'], function () {
            Route::get('index', [WithdrawalController::class, 'index'])->name('transaction.withdrawal.index');
            Route::get('create', [WithdrawalController::class, 'create'])->name('transaction.withdrawal.create');
            Route::post('store', [WithdrawalController::class, 'store'])->name('transaction.withdrawal.store');
        });
    });
});

require __DIR__ . '/auth.php';
