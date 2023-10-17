<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function createBuyTransaction(Request $request)
    {
        $this->validate($request, [
            'currencyId' => 'required',
            'amount' => 'required',
            'userId' => 'required',
        ]);

        $trxData = $request->only(['userId', 'currencyId', 'amount']);

        $this->transactionService->createTransaction($trxData['userId'], "buy", $trxData['currencyId'], $trxData['amount']);

        return response()->json(["message" => "success"], 201);
    }

    public function createSellTransaction(Request $request)
    {
        $this->validate($request, [
            'currencyId' => 'required',
            'amount' => 'required',
            'userId' => 'required',
        ]);

        $trxData = $request->only(['userId', 'currencyId', 'amount']);

        $isUserBalanceEnough = $this->transactionService->isBalanceEnough($trxData['userId'], $trxData['currencyId'], $trxData['amount']);
        if(!$isUserBalanceEnough) {
            return response()->json(["message" => "Insufficient funds"], 400);
        }

        $this->transactionService->createTransaction($trxData['userId'], "sell", $trxData['currencyId'], $trxData['amount']);

        return response()->json(["message" => "success"], 201);
    }
}
