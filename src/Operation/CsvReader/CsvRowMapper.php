<?php

declare(strict_types=1);

namespace App\Operation\CsvReader;

use App\Operation\Operation;

class CsvRowMapper
{
    /**
     * @throws \DateMalformedStringException
     * @throws \InvalidArgumentException
     */
    public function mapRowToDto(array $row): Operation
    {
        return new Operation(
            $row[0],
            (int) $row[1],
            $row[2],
            $row[3],
            (float) $row[4],
            $row[5],
        );
    }
}
