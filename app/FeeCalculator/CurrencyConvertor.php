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

    public function convertToEUR($amount, $currency): float
    {
        if ('EUR' === $currency) {
            return $amount;
        }

        return Operation::round($amount / $this->rates[$currency]);
    }

    public function convertFromEUR($amount, $currency): float
    {
        if ('EUR' === $currency) {
            return $amount;
        }

        return Operation::round($amount * $this->rates[$currency]);
    }

    private function loadRates(): void
    {
        $this->rates = Http::get('https://api.exchangeratesapi.io/latest')['rates'] ?? [];
    }
}
