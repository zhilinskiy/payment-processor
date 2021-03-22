<?php


namespace App\FeeCalculator;


class CsvFeeCalculator implements CsvFeeCalculatorInterface
{
    private Calculator $calculator;
    private CurrencyConvertorInterface $convertor;

    public function __construct(Calculator $calculator, CurrencyConvertorInterface $convertor)
    {
        $this->calculator = $calculator;
        $this->convertor = $convertor;
    }

    public function calculateFees(string $source): array
    {
        return $this->calculator->calculateFees(
            $this->getOperationsFromFile($source)
        );
    }

    private function getOperationsFromFile(string $source): array
    {
        return $this->prepareOperations(
            $this->parseFile($source)
        );
    }

    private function parseFile(string $source): array
    {
        $handle = fopen($source, 'r');
        $operations = [];
        while (($csvLine = fgetcsv($handle)) !== FALSE) {
            $operations[] = new Operation(...$csvLine);
        }

        return $operations;
    }

    private function prepareOperations(array $operations): array
    {
        $prevOperation = null;
        foreach ($operations as &$operation) {
            if ($operation->isPrivateWithdraw()) {
                if (!$prevOperation || !$prevOperation->isOnSameWeek($operation)) {
                    $operation->weeklyCount = 1;
                    $operation->weeklyAmount = $this->convertor->convertToEUR($operation->amount, $operation->currency);
                } else {
                    $operation->weeklyCount = $prevOperation->weeklyCount + 1;
                    $operation->weeklyAmount = $prevOperation->weeklyAmount +
                        $this->convertor->convertToEUR($operation->amount, $operation->currency);
                }
                $prevOperation = $operation;
            }
        }

        return $operations;
    }
}
