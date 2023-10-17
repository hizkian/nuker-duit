<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createTransaction($userId, $transactionType, $currencyId, $amount) {
        $this->transactionRepository->createTransaction($userId, $transactionType, $currencyId, $amount);
    }
}