<?php

namespace App\Service\CsvReader;

class CsvReader
{
    public function __construct(private CsvRowMapper $csvMapper, private string $filePath)
    {
    }

    /**
     * @return \Generator|CsvRow[]
     * @throws \Exception
     */
    public function read(): generator
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception("File not found: {$this->filePath}");
        }

        if (($handle = fopen($this->filePath, 'r')) === false) {
            throw new \Exception("Unable to open file: {$this->filePath}");
        }

        while (($row = fgetcsv($handle)) !== false) {
            yield $this->csvMapper->mapRowToDto($row);
        }
        
        fclose($handle);
    }
}