<?php

namespace App\Providers;

use App\FeeCalculator\Calculator;
use App\FeeCalculator\CsvFeeCalculator;
use App\FeeCalculator\CsvFeeCalculatorInterface;
use App\FeeCalculator\CurrencyConvertor;
use App\FeeCalculator\CurrencyConvertorInterface;
use Illuminate\Support\ServiceProvider;

class FeeCalculatorServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        CsvFeeCalculatorInterface::class => CsvFeeCalculator::class,
    ];
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public array $singletons = [
        CurrencyConvertorInterface::class => CurrencyConvertor::class,
    ];

    public function boot(): void
    {
        $this->app->tag(
            $this->app->config->get('fee-calculator.calculators'),
            ['feeCalculator']
        );

        $this->app->bind(Calculator::class, function ($app) {
            return new Calculator($app->tagged('feeCalculator'));
        });
    }

}
