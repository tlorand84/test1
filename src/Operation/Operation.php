<?php

declare(strict_types=1);

namespace App\Operation;

class Operation
{
    public const USER_TYPE_PRIVATE = 'private';
    public const USER_TYPE_BUSINESS = 'business';
    public const OPERATION_TYPE_DEPOSIT = 'deposit';
    public const OPERATION_TYPE_WITHDRAW = 'withdraw';

    protected const USER_TYPES = [
        self::USER_TYPE_PRIVATE,
        self::USER_TYPE_BUSINESS,
    ];

    protected const OPERATION_TYPES = [
        self::OPERATION_TYPE_DEPOSIT,
        self::OPERATION_TYPE_WITHDRAW,
    ];

    private int $operationTimestamp;

    /**
     * @throws \DateMalformedStringException
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $operationDate,
        private int $userId,
        private string $userType,
        private string $operationType,
        private float $amount,
        private string $currency,
    ) {
        $this->operationTimestamp = (new \DateTime($operationDate))->getTimestamp();
        $this->validateUserType();
        $this->validateOperationType();
    }

    private function validateUserType(): void
    {
        if (!in_array($this->userType, static::USER_TYPES, true)) {
            throw new \InvalidArgumentException('Invalid user type');
        }
    }

    private function validateOperationType(): void
    {
        if (!in_array($this->operationType, static::OPERATION_TYPES, true)) {
            throw new \InvalidArgumentException('Invalid operation type');
        }
    }

    public function getOperationTimestamp(): int
    {
        return $this->operationTimestamp;
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
