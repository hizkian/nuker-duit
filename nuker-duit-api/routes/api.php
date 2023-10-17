<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/logout', [UserController::class, 'logout']);
Route::middleware(['checkBearerToken'])->get('/exchange-rates', [ExchangeRateController::class, 'getExchangeRates']);
Route::middleware(['checkBearerToken'])->post('/transactions/buy', [TransactionController::class, 'createBuyTransaction']);
Route::middleware(['checkBearerToken'])->post('/transactions/sell', [TransactionController::class, 'createSellTransaction']);