<?php

namespace App\Service\CsvReader;

use App\Service\OperationFeeCalculator\OperationConstants;
use App\Service\OperationFeeCalculator\OperatorInterface;

class CsvRow implements OperatorInterface
{
    public function __construct(
        string $operationDate,
        private int $userId,
        private string $userType,
        private string $operationType,
        private float $amount,
        private string $currency
    ) {
        $this->operationDate = new \DateTime($operationDate);
        $this->validateUserType();
        $this->validateOperationType();
    }

    private function validateUserType(): void
    {
        if (!in_array($this->userType, OperationConstants::USER_TYPES)) {
            throw new \InvalidArgumentException('Invalid user type');
        }
    }

    private function validateOperationType(): void
    {
        if (!in_array($this->operationType, OperationConstants::OPERATION_TYPES)) {
            throw new \InvalidArgumentException('Invalid operation type');
        }
    }

    public function getOperationDate(): \DateTime
    {
        return $this->operationDate;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
