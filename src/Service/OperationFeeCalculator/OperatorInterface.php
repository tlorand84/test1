<?php

namespace App\Service\OperationFeeCalculator;

interface OperatorInterface
{
    public function getDate(): \DateTime;
    public function getUserType(): string;
    public function getOperationType(): string;
    public function getAmount(): float;
    public function getCurrency(): string;
}