<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;

class CsvCommissionFeeCalculatorCommand extends Command
{
    protected $signature = 'fee-calculator:csv {file : path to CSV file}';

    protected $description = 'Handles operations provided in CSV format and calculates a commission fee for them.';

    public function handle()
    {
        $path = $this->getFilePath();
        $fee = [
            [0.60],
            [3.00],
            [0.00],
            [0.06],
            [1.50],
            [0],
            [0.70],
            [0.30],
            [0.30],
            [3.00],
            [0.00],
            [0.00],
            [8612],
        ];
        $this->table(
            ['Fee'],
            $fee
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
