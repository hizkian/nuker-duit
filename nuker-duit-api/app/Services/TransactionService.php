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
    
    public function getTransactionsByUserId(int $userId, string $transactionType, int $currencyId) {
        return $this->transactionRepository->getTransactionsByUserId($userId, $transactionType, $currencyId);
    }

    public function isBalanceEnough($userId, $currencyId, $amount) {
        $userBalance = $this->transactionRepository->getBalanceByUserId($userId, $currencyId);

        return $userBalance >= $amount;
    }
}