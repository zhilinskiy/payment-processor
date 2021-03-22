<?php


namespace App\FeeCalculator;


class PrivateWithdrawCalculator implements FeeCalculatorInterface
{
    public const FEE = 0.3;
    public const WEEKLY_LIMIT_COUNT = 3;
    public const WEEKLY_LIMIT_AMOUNT = 1000;
    private static array $limitExceeded = [];
    private CurrencyConvertorInterface $convertor;

    public function __construct(CurrencyConvertorInterface $convertor)
    {
        $this->convertor = $convertor;
    }

    public function canCalculate(Operation $operation): bool
    {
        return $operation->isPrivateWithdraw();
    }

    public function calculate(Operation $operation): float
    {
        // Commission fee - 0.3% from withdrawn amount.
        // 1000.00 EUR for a week (from Monday to Sunday)
        // is free of charge. Only for the first 3 withdraw operations per a week.
        // 4th and the following operations are calculated by using the rule above (0.3%).
        // If total free of charge amount is exceeded them commission is calculated only
        // for the exceeded amount (i.e. up to 1000.00 EUR no commission fee is applied).
        if ($operation->weeklyAmount <= self::WEEKLY_LIMIT_AMOUNT
            && $operation->weeklyCount <= self::WEEKLY_LIMIT_COUNT) {

            return 0.00;
        }
        $amount = $operation->amount;
        if ($operation->weeklyCount <= self::WEEKLY_LIMIT_COUNT
            && $operation->weeklyAmount > self::WEEKLY_LIMIT_AMOUNT
            && $this->limitExceededFirstTime($operation)) {
            $eurAmount = $operation->weeklyAmount - self::WEEKLY_LIMIT_AMOUNT;
            $amount = $this->convertor->convertFromBaseCurrency($eurAmount, $operation->currency);
        }

        return Operation::getPercentsFrom(self::FEE, $amount);
    }

    private function limitExceededFirstTime(Operation $operation): bool
    {
        foreach (self::$limitExceeded as $exceededOperation) {
            if ($exceededOperation->isOnSameWeek($operation)) {

                return false;
            }
        }
        self::$limitExceeded[] = $operation;

        return true;
    }
}
