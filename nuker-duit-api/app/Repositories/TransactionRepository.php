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

    public function getTransactionsByUserId(int $userId, string $transactionType, int $currencyId)
    {
        $query = "SELECT * FROM transactions WHERE user_id = {$userId} AND deleted_at IS NULL";

        if($transactionType) {
            $query .= " AND transaction_type = '{$transactionType}'";
        }

        if($currencyId) {
            $query .= " AND currency_id = {$currencyId}";
        }

        $result = DB::select($query);

        return $result;
    }

    public function getBalanceByUserId(int $userId, int $currencyId)
    {
        $query = "SELECT SUM(CASE WHEN transaction_type = 'sell' THEN -amount ELSE amount END) AS total FROM transactions WHERE user_id = {$userId} AND deleted_at IS NULL AND transaction_type IN ('sell', 'buy')";

        if($currencyId) {
            $query .= " AND currency_id = {$currencyId}";
        }

        $result = DB::select($query);
        $total = $result[0]->total;

        return $total;
    }
}
