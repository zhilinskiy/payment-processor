<?php


namespace App\FeeCalculator;


interface FeeCalculatorInterface
{
    public function canCalculate(Operation $operation): bool;

    public function calculate(Operation $operation): float;
}
