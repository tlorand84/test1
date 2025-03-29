<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\CurrencyExchangeRate\CurrencyExchangeRateInterface;
use App\Operation\Operation;

class OperationFeeCalculatorFactory
{
    public static function createOperationFeeCalculator(
        Operation $operation,
        CurrencyExchangeRateInterface $exchangeRate,
    ): OperationFeeCalculatorInterface {
        return match ($operation->getOperationType()) {
            Operation::OPERATION_TYPE_DEPOSIT => new Deposit($operation),
            Operation::OPERATION_TYPE_WITHDRAW => self::createWithdrawFeeCalculator($operation, $exchangeRate),
            default => throw new \InvalidArgumentException("Unsupported operation type: {$operation->getOperationType()}"),
        };
    }

    private static function createWithdrawFeeCalculator(
        Operation $operation,
        CurrencyExchangeRateInterface $exchangeRate,
    ): OperationFeeCalculatorInterface {
        if ($operation->getUserType() === Operation::USER_TYPE_PRIVATE) {
            return new PrivateWithdraw($operation, $exchangeRate);
        }

        return new BusinessWithdraw($operation);
    }
}
