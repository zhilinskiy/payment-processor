<?php


namespace App\FeeCalculator;


interface CurrencyConvertorInterface
{
    public function convertToEUR($amount, $currency): float;

    public function convertFromEUR($amount, $currency): float;
}
