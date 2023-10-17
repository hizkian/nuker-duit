<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExchangeRateController;

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
Route::get('/exchange-rates', [ExchangeRateController::class, 'getExchangeRates']);