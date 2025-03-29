<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class BaseFeeCalculator implements OperationFeeCalculatorInterface
{
    protected const float FEE_PERCENTAGE = 0;
    protected const array SPECIAL_CURRENCY_DECIMALS = [
        'CVE' => 0,
        'DJF' => 0,
        'IQD' => 0,
        'JPY' => 0,
        'MGA' => 0,
        'MRU' => 0,
        'PYG' => 0,
        'RWF' => 0,
        'UGX' => 0,
        'VND' => 0,
        'VUV' => 0,
        'XAF' => 0,
        'XOF' => 0,
        'XPF' => 0,
        'YER' => 0,
        'BHD' => 3,
        'JOD' => 3,
        'KWD' => 3,
    ];

    public function __construct(protected Operation $operation)
    {
    }

    /**
     * Float value rounded up to currency decimals.
     */
    public function calculateFee(): float
    {
        $currencyDecimals = static::SPECIAL_CURRENCY_DECIMALS[$this->operation->getCurrency()] ?? 2;

        return $this->roundUp($this->getChargeableAmount() * static::FEE_PERCENTAGE / 100, $currencyDecimals);
    }

    protected function getChargeableAmount(): float
    {
        return $this->operation->getAmount();
    }

    protected function roundUp(float $value, int $precision): float
    {
        $pow = 10 ** $precision;

        return ceil($value * $pow) / $pow;
    }
}
