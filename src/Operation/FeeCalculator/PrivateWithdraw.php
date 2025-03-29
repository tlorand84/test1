<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\CurrencyExchangeRate\CurrencyExchangeRateInterface;
use App\CurrencyExchangeRate\InvalidResponseException;
use App\Operation\Operation;
use App\Operation\OperationsRepository;

class PrivateWithdraw extends BaseFeeCalculator
{
    protected const float FEE_PERCENTAGE = 0.3;
    protected const float FREE_WEEKLY_AMOUNT = 1000.00;
    protected const string FREE_WEEKLY_CURRENCY = 'EUR';
    protected const int FREE_MAX_PER_WEEK = 3;

    public function __construct(Operation $operation, protected CurrencyExchangeRateInterface $exchangeRate)
    {
        parent::__construct($operation);
    }

    /**
     * @throws InvalidResponseException
     */
    protected function getChargeableAmount(): float
    {
        $prevUserOperations = OperationsRepository::getGivenWeekOperationsByTypeAndUserId(
            $this->operation->getOperationTimestamp(),
            $this->operation->getOperationType(),
            $this->operation->getUserId(),
        );

        if (count($prevUserOperations) < static::FREE_MAX_PER_WEEK) {
            return $this->getChargeableAmountByTotalAmounts($prevUserOperations);
        }

        return $this->operation->getAmount();
    }

    /**
     * @param Operation[] $prevUserOperations
     *
     * @throws InvalidResponseException
     */
    private function getChargeableAmountByTotalAmounts(array $prevUserOperations): float
    {
        $prevTotalAmount = $this->getPreviousOperationsTotalAmount($prevUserOperations);

        // if previous operations exceeded the free limit -> apply fee to the entire amount of the new operation
        if ($prevTotalAmount - static::FREE_WEEKLY_AMOUNT >= 0) {
            return $this->operation->getAmount();
        }

        if ($this->operation->getCurrency() !== static::FREE_WEEKLY_CURRENCY) {
            return $this->getChargeableAmountOfDifferentCurrency($prevTotalAmount);
        }

        return max(0.0, $prevTotalAmount + $this->operation->getAmount() - static::FREE_WEEKLY_AMOUNT);
    }

    /**
     * Sums all the previous operations of the user from the actual week converting each amount to EUR (if it isn't already).
     *
     * @return float the total amount of the actual week in EUR (static::FREE_WEEKLY_CURRENCY)
     *
     * @throws InvalidResponseException
     */
    private function getPreviousOperationsTotalAmount(array $prevUserOperations): float
    {
        $totalAmount = 0.0;
        foreach ($prevUserOperations as $operation) {
            if ($operation->getCurrency() !== static::FREE_WEEKLY_CURRENCY) {
                $inversExchangeRate = $this->exchangeRate->getExchangeRate(static::FREE_WEEKLY_CURRENCY, $operation->getCurrency());
                $amount = $operation->getAmount() / $inversExchangeRate;
            } else {
                $amount = $operation->getAmount();
            }

            $totalAmount += $amount;
        }

        return $totalAmount;
    }

    /**
     * If the current operation's currency differs from eur -> convert
     * Sum with the user's total amount from this week (in eur) and remove the free amount to get the chargeable amount
     * Convert back to the original currency.
     *
     * @throws InvalidResponseException
     */
    private function getChargeableAmountOfDifferentCurrency(float $prevTotalAmount): float
    {
        $inversExchangeRate = $this->exchangeRate->getExchangeRate(static::FREE_WEEKLY_CURRENCY, $this->operation->getCurrency());
        $currentOperationAmount = $this->operation->getAmount() / $inversExchangeRate;
        $chargeableAmount = max(0.0, $prevTotalAmount + $currentOperationAmount - static::FREE_WEEKLY_AMOUNT);

        return $chargeableAmount * $inversExchangeRate;
    }
}
