<?php

namespace App\Services;

use App\Vendors\CurrencyApi;
use App\Repositories\ExchangeRateRepository;
use App\Repositories\CurrencyRepository;

class ExchangeRateService
{
    protected $currencyApi;
    protected $exchangeRateRepository;
    protected $currencyRepository;

    public function __construct(CurrencyApi $currencyApi, ExchangeRateRepository $exchangeRateRepository, CurrencyRepository $currencyRepository)
    {
        $this->currencyApi = $currencyApi;
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function updateExchangeRates() {
        $currencies = $this->currencyRepository->getCurrencies();

        $newExchangeRates = array();
        foreach($currencies as $currency) {
            $data = $this->currencyApi->fetchCurrencyData($currency->name);
            $idr_rate = 0;
            foreach($data as $key=>$val) {
                if($key == "idr") {
                    $idr_rate = floatval($val);
                }
            }
            $newExchangeRates[$currency->id] = number_format($idr_rate, 2, '.', '');
        }

        $currentExchangeRates = $this->exchangeRateRepository->getExchangeRates();
        if(count($currentExchangeRates) == 0) {
            $this->exchangeRateRepository->insertMultipleExchangeRates($newExchangeRates);

            return true;
        }

        foreach($newExchangeRates as $currencyId=>$exchangeRate) {
            $this->exchangeRateRepository->updateExchangeRate($currencyId, $exchangeRate);
        }
    }
}