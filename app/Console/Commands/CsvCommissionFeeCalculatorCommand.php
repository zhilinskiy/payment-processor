<?php

namespace App\Console\Commands;

use App\FeeCalculator\CsvFeeCalculatorInterface;
use Illuminate\Console\Command;
use InvalidArgumentException;

class CsvCommissionFeeCalculatorCommand extends Command
{
    protected $signature = 'fee-calculator:csv {file : path to CSV file}';

    protected $description = 'Handles operations provided in CSV format and calculates a commission fee for them.';

    public function handle(CsvFeeCalculatorInterface $calculator): void
    {
        $this->table(
            ['Fee'],
            $calculator->calculateFees($this->getFilePath())
        );
    }

    public function getFilePath(): string
    {
        $filePath = $this->argument('file');
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException(sprintf('File not found at: %s. Current directory: %s', $filePath, getcwd()));
        }

        return $filePath;
    }
}
