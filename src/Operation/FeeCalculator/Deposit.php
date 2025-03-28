<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

class Deposit extends BaseFeeCalculator
{
    protected const float FEE_PERCENTAGE = 0.03;
}
