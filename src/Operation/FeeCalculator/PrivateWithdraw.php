<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;
use App\Operation\OperationsRepository;

class PrivateWithdraw extends BaseFeeCalculator
{
    protected const float FEE_PERCENTAGE = 0.3;
    protected const float FREE_WEEKLY_AMOUNT = 1000.00;
    protected const string FREE_WEEKLY_CURRENCY = 'EUR';
    protected const int FREE_MAX_PER_WEEK = 3;

    protected function getChargeableAmount(): float
    {
        $prevUserOperations = OperationsRepository::getGivenWeekOperationsByUserId(
            $this->operation->getOperationTimestamp(),
            $this->operation->getUserId(),
        );

        if (count($prevUserOperations) < static::FREE_MAX_PER_WEEK) {
            return $this->getChargeableAmountByTotalAmounts($prevUserOperations);
        }

        return $this->operation->getAmount();
    }

    /**
     * @param Operation[] $prevUserOperations
     */
    private function getChargeableAmountByTotalAmounts(array $prevUserOperations): float
    {
        // TODO convert all amount to eur if is not eur
        $totalAmount = 0;
        foreach ($prevUserOperations as $operation) {
            $totalAmount += $operation->getAmount();
        }

        if ($totalAmount - static::FREE_WEEKLY_AMOUNT >= 0) {
            return $this->operation->getAmount();
        }

        return max(0, $totalAmount - static::FREE_WEEKLY_AMOUNT + $this->operation->getAmount());


        // TODO if the current operation currency is not eur and this value is > 0, convert this value to the current operation's currency
    }
}
