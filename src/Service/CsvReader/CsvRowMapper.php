<?php

namespace App\Service\CsvReader;


class CsvRowMapper
{
    public function mapRowToDto(array $row): CsvRow
    {
        return new CsvRow(
            $row[0],
            (int) $row[1],
            $row[2],
            $row[3],
            (float) $row[4],
            $row[5],
        );
    }
}