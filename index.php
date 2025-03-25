<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

if ($argc < 2) {
    die("Usage: php index.php <csv_file_path>\n");
}

$csvFilePath = $argv[1];

$csvReader = new App\Service\CsvReader\CsvReader(
    new App\Service\CsvReader\CsvRowMapper(),
    $csvFilePath
);

foreach ($csvReader->read() as $csvRow) {
    $operation = OperationFactory::createOperation($csvRow);

    echo $operation->execute() . PHP_EOL;
}