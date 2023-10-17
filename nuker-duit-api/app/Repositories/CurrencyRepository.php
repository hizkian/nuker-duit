<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CurrencyRepository
{
    public function getCurrencies()
    {
        $query = "SELECT * FROM currencies ORDER BY id ASC";

        $currencies = DB::select($query);

        return $currencies;
    }
}
