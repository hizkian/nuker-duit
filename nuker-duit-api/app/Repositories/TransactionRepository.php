<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function createTransaction(int $userId, string $transactionType, $currencyId, $amount)
    {
        $query = "INSERT INTO transactions (created_at, updated_at, user_id, transaction_type, currency_id, amount) VALUES (NOW(), NOW(), {$userId}, '{$transactionType}', {$currencyId}, {$amount})";

        DB::statement($query);
    }
}
