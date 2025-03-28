<?php

namespace App\Tests\Functional;

use App\Operation\CsvReader\CsvRowMapper;
use App\Operation\FeeCalculator\OperationFeeCalculatorFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    #[DataProvider('dataProviderForFeeCalculationTesting')]
    public function testOperationFeeCalculator(array $csvRow, float $expectedFee): void
    {
        $csvMapper = new CsvRowMapper();
        $feeCalculator = OperationFeeCalculatorFactory::createOperationFeeCalculator($csvMapper->mapRowToDto($csvRow));

        $this->assertEquals(
            $expectedFee,
            $feeCalculator->calculateFee(),
        );
    }

    public static function dataProviderForFeeCalculationTesting(): array
    {
        return [
            [
                ['2014-12-31', '4', 'private', 'withdraw', '1200.00', 'EUR'],
                0.60,
            ],
            [
                ['2015-01-01', '4', 'private', 'withdraw', '1000.00', 'EUR'],
                3.00,
            ],
            [
                ['2016-01-05', '4', 'private', 'withdraw', '1000.00', 'EUR'],
                0.00,
            ],
            [
                ['2016-01-05', '1', 'private', 'deposit', '200.00', 'EUR'],
                0.06,
            ],
            [
                ['2016-01-06', '2', 'business', 'withdraw', '300.00', 'EUR'],
                1.50,
            ],
            [
                ['2016-01-06', '1', 'private', 'withdraw', '30000', 'JPY'],
                0.00,
            ],
            [
                ['2016-01-07', '1', 'private', 'withdraw', '1000.00', 'EUR'],
                0.70,
            ],
            [
                ['2016-01-07', '1', 'private', 'withdraw', '100.00', 'USD'],
                0.30,
            ],
            [
                ['2016-01-10', '1', 'private', 'withdraw', '100.00', 'EUR'],
                0.30,
            ],
            [
                ['2016-01-10', '2', 'business', 'deposit', '10000.00', 'EUR'],
                3.00,
            ],
            [
                ['2016-01-10', '3', 'private', 'withdraw', '1000.00', 'EUR'],
                0.00,
            ],
            [
                ['2016-02-15', '1', 'private', 'withdraw', '300.00', 'EUR'],
                0.00,
            ],
            [
                ['2016-02-19', '5', 'private', 'withdraw', '3000000', 'JPY'],
                8612,
            ],
        ];
    }
}
