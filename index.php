<?php

declare(strict_types=1);

use App\CurrencyExchangeRate\ExchangeRateApi;
use App\Operation\CsvReader\CsvReader;
use App\Operation\CsvReader\CsvRowMapper;
use App\Operation\FeeCalculator\OperationFeeCalculatorFactory;
use App\Operation\OperationsRepository;

require_once __DIR__ . '/vendor/autoload.php';

if ($argc < 2) {
    die("Usage: php index.php <csv_file_path>\n");
}

putenv("EXCHANGE_RATE_API_KEY=ef47c61660e8df73acbf74d2");

$csvReader = new CsvReader(
    new CsvRowMapper(),
    $argv[1]
);

$converter = new ExchangeRateApi();

try {
    foreach ($csvReader->read() as $operation) {
        $feeCalculator = OperationFeeCalculatorFactory::createOperationFeeCalculator($operation, $converter);

        echo $feeCalculator->calculateFee() . PHP_EOL;

        OperationsRepository::addOperation($operation);
    }
} catch (\DateMalformedStringException $e) {
    echo 'ERROR occurred:' . $e->getMessage() . PHP_EOL;
}