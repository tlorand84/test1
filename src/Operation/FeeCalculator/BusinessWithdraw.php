<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

class BusinessWithdraw extends Deposit
{
    protected const FEE_PERCENTAGE = 0.5;
}
