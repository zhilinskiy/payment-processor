<?php


namespace App\FeeCalculator;


class Calculator
{
    private $feesCalculators;

    public function __construct($feesCalculators = [])
    {
        $this->feesCalculators = $feesCalculators;
    }

    public function calculateFees(array $operations): array
    {
        $fees = [];
        foreach ($operations as $operation) {
            $fees[] = [sprintf('%01.2f', $this->calculateFeeForOperation($operation))];
        }

        return $fees;
    }

    private function calculateFeeForOperation($operation): float
    {
        $fee = 0.00;
        foreach ($this->feesCalculators as $calculator) {
            if ($calculator->canCalculate($operation)) {
                $fee = $calculator->calculate($operation);
                break;
            }
        }

        return $fee;
    }
}
