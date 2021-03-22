<?php


namespace App\FeeCalculator;


interface CurrencyConvertorInterface
{
    public function convertToBaseCurrency($amount, $currency): float;

    public function convertFromBaseCurrency($amount, $currency): float;

    public function baseCurrency(): string;
}
