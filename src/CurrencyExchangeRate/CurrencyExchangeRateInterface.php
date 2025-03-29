<?php

declare(strict_types=1);

namespace App\CurrencyExchangeRate;

interface CurrencyExchangeRateInterface
{
    /**
     * @throws InvalidResponseException
     */
    public function getExchangeRate(string $currencyFrom, string $currencyTo): float;
}
