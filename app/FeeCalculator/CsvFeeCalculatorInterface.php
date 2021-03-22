<?php


namespace App\FeeCalculator;

interface CsvFeeCalculatorInterface
{
    public function calculateFees(string $source): array;
}
