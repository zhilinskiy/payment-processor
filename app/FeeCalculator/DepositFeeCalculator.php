<?php


namespace App\FeeCalculator;


class DepositFeeCalculator implements FeeCalculatorInterface
{

    public const FEE = 0.03;

    public function canCalculate(Operation $operation): bool
    {
        return $operation->isDeposit();
    }

    public function calculate(Operation $operation): float
    {
        // All deposits are charged 0.03% of deposit amount.
        return Operation::getPercentsFrom(self::FEE, $operation->amount);
    }
}
