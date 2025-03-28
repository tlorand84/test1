<?php

declare(strict_types=1);

use App\Operation\CsvReader\CsvReader;
use App\Operation\CsvReader\CsvRowMapper;
use App\Operation\FeeCalculator\OperationFeeCalculatorFactory;
use App\Operation\OperationsRepository;

require_once __DIR__ . '/vendor/autoload.php';

if ($argc < 2) {
    die("Usage: php index.php <csv_file_path>\n");
}

$csvFilePath = $argv[1];

$csvReader = new CsvReader(
    new CsvRowMapper(),
    $csvFilePath
);

try {
    foreach ($csvReader->read() as $operation) {
        $feeCalculator = OperationFeeCalculatorFactory::createOperationFeeCalculator($operation);

        echo $feeCalculator->calculateFee() . PHP_EOL;

        OperationsRepository::addOperation($operation);
    }
} catch (\DateMalformedStringException $e) {
    echo 'ERROR occurred:' . $e->getMessage() . PHP_EOL;
}