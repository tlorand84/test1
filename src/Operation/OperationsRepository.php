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
    public static function getOperationsByUserId(int $userId): array
    {
        return self::$operations[$userId] ?? [];
    }
}