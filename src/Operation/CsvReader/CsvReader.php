<?php

declare(strict_types=1);

namespace App\Operation\CsvReader;

use App\Operation\Operation;

class CsvReader
{
    public function __construct(private CsvRowMapper $csvMapper, private string $filePath)
    {
    }

    /**
     * @return iterable|Operation[]
     *
     * @throws \RuntimeException
     * @throws \DateMalformedStringException
     * @throws \InvalidArgumentException
     */
    public function read(): iterable
    {
        if (!file_exists($this->filePath)) {
            throw new \RuntimeException("File not found: {$this->filePath}");
        }

        if (($handle = fopen($this->filePath, 'rb')) === false) {
            throw new \RuntimeException("Unable to open file: {$this->filePath}");
        }

        while (($row = fgetcsv($handle)) !== false) {
            yield $this->csvMapper->mapRowToDto($row);
        }

        fclose($handle);
    }
}
