<?php


namespace App\FeeCalculator;


class BusinessWithdrawCalculator implements FeeCalculatorInterface
{
    public const FEE = 0.5;

    public function canCalculate(Operation $operation): bool
    {
        return $operation->isBusinessWithdraw();
    }

    public function calculate(Operation $operation): float
    {
        // Commission fee - 0.5% from withdrawn amount.
        return Operation::getPercentsFrom(self::FEE, $operation->amount);
    }
}
