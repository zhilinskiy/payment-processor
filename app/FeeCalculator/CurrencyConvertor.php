<?php


namespace App\FeeCalculator;


use Illuminate\Support\Facades\Http;

class CurrencyConvertor implements CurrencyConvertorInterface
{
    private array $rates = [];

    public function __construct()
    {
        $this->loadRates();
    }

    public function convertToBaseCurrency($amount, $currency): float
    {
        if ($this->baseCurrency() === $currency) {
            return $amount;
        }

        return Operation::round($amount / $this->rates[$currency]);
    }

    public function convertFromBaseCurrency($amount, $currency): float
    {
        if ($this->baseCurrency() === $currency) {
            return $amount;
        }

        return Operation::round($amount * $this->rates[$currency]);
    }

    public function baseCurrency(): string
    {
        return config('fee-calculator.baseCurrency');
    }

    private function loadRates(): void
    {
        $this->rates = Http::get('https://api.exchangeratesapi.io/latest')['rates'] ?? [];
    }
}
