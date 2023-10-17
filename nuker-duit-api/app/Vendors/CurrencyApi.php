<?php

namespace App\Vendors;

use Illuminate\Support\Facades\Http;

class CurrencyApi 
{
    public function fetchCurrencyData($currencyType)
    {
        $url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/{$currencyType}/idr.json";
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            return $data;
        } else {
            $errorMessage = $response->status() . ': ' . $response->body();
            return response()->json(['error' => $errorMessage], $response->status());
        }
    }
}