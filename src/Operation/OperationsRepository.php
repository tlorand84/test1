<?php

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
    public static function getGivenWeekOperationsByUserId( int $weekdayTimestamp, int $userId): array
    {
        $monday = strtotime('monday this week', $weekdayTimestamp);

        return array_filter(self::$operations[$userId] ?? [], static function (Operation $operation) use ($monday, $weekdayTimestamp) {
            return $operation->getOperationTimestamp() >= $monday && $operation->getOperationTimestamp() <= $weekdayTimestamp;
        });
    }
}