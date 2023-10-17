<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ExchangeRateRepository
{
    public function insertMultipleExchangeRates($exchangeRates)
    {
        $query = "INSERT INTO exchange_rates (currency_id, idr_rate, created_at, updated_at) VALUES ";
        foreach ($exchangeRates as $currencyId=>$exchangeRate) {
            $query = $query . "({$currencyId}, {$exchangeRate}, NOW(), NOW()),";
        }

        $query = rtrim($query, ',');

        DB::statement($query);
    }

    public function getExchangeRates()
    {
        $query = "SELECT currency_id, idr_rate FROM exchange_rates WHERE deleted_at IS NULL";

        $exchangeRates = DB::select($query);

        return $exchangeRates;
    }

    public function updateExchangeRate($currencyId, $idrRate)
    {
        $query = "UPDATE exchange_rates SET idr_rate = {$idrRate}, updated_at = NOW() WHERE currency = {$currencyId}";

        DB::statement($query);
    }

    public function getExchangeRatesWithName()
    {
        $query = "SELECT er.currency_id, c.name, er.idr_rate FROM exchange_rates er JOIN currencies c ON er.currency_id = c.id  WHERE deleted_at IS NULL";

        $exchangeRates = DB::select($query);

        return $exchangeRates;
    }
}
