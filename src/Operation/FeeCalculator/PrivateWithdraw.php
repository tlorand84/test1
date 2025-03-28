<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

class PrivateWithdraw extends BaseFeeCalculator
{
    protected const FEE_PERCENTAGE = 0.3;

    public function calculateFee(): float
    {
        return parent::calculateFee();
    }

    private function freeByCalendar()
    {

    }
}
