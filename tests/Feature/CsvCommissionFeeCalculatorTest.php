<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Tests\TestCase;

class CsvCommissionFeeCalculatorTest extends TestCase
{
    public function test_it_trow_exception_if_file_not_found(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->artisan('fee-calculator:csv file.csv');
    }

    public function test_it_produce_right_output_from_test_file(): void
    {
        Http::fake([
            // Stub a response for all endpoints...
            '*' => Http::response(['rates' => ['USD' => 1.1497, 'JPY' => 129.53,]], 200),
        ]);
        $this->artisan(sprintf('fee-calculator:csv %s', base_path('tests/test.csv')))
            ->expectsTable([
                'Fee',
            ], [
                ['0.60'],
                ['3.00'],
                ['0.00'],
                ['0.06'],
                ['1.50'],
                ['0.00'],
                ['0.69'],
                ['0.30'],
                ['0.30'],
                ['3.00'],
                ['0.00'],
                ['0.00'],
                ['8611.41'],
            ]);
    }
}
