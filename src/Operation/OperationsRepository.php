<?php

declare(strict_types=1);

namespace App\Operation;

class OperationsRepository
{
    /**
     * @var array<int, array<int, Operation>>
     */
    private static array $operations = [];

    public static function addOperation(Operation $operation): void
    {
        self::$operations[$operation->getUserId()][] = $operation;
    }

    /**
     * @return Operation[]
     */
    public static function getGivenWeekOperationsByTypeAndUserId(
        int $weekdayTimestamp,
        string $operationType,
        int $userId,
    ): array {
        $monday = strtotime('monday this week', $weekdayTimestamp);

        return array_filter(
            self::$operations[$userId] ?? [],
            static function (Operation $operation) use ($operationType, $monday, $weekdayTimestamp) {
                return
                    $operation->getOperationType() === $operationType
                    && $operation->getOperationTimestamp() >= $monday
                    && $operation->getOperationTimestamp() <= $weekdayTimestamp
                ;
            },
        );
    }
}
