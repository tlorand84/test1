<?php

declare(strict_types=1);

require_once __DIR__ . 'vendor/autoload.php';

if ($argc < 2) {
    die("Usage: php index.php <csv_file_path>\n");
}

$csvFilePath = $argv[1];

$csvReader = new App\Operation\CsvReader\CsvReader(
    new App\Operation\CsvReader\CsvRowMapper(),
    $csvFilePath
);

foreach ($csvReader->read() as $csvRow) {
    $operation = App\Operation\FeeCalculator\OperationFeeCalculatorFactory::createOperationFeeCalculator($csvRow);

    echo $operation->calculateFee() . PHP_EOL;
}