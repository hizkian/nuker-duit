<?php

namespace App\Http\Controllers;

use App\Services\ExchangeRateService;

class ExchangeRateController extends Controller
{
    protected $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function getExchangeRates()
    {
        $exchangeRates = $this->exchangeRateService->getExchangeRatesWithName();

        return response()->json(["list" => $exchangeRates], 200);
    }
}
