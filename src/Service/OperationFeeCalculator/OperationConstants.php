<?php

namespace App\Service\OperationFeeCalculator;

class OperationConstants
{
    public const USER_TYPE_PRIVATE = 'private';
    public const USER_TYPE_BUSINESS = 'business';
    public const OPERATION_TYPE_DEPOSIT = 'deposit';
    public const OPERATION_TYPE_WITHDRAW = 'withdraw';

    public const USER_TYPES = [
        self::USER_TYPE_PRIVATE,
        self::USER_TYPE_BUSINESS,
    ];

    public const OPERATION_TYPES = [
        self::OPERATION_TYPE_DEPOSIT,
        self::OPERATION_TYPE_WITHDRAW,
    ];
}