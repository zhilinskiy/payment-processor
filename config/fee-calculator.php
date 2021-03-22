<?php

use App\FeeCalculator\BusinessWithdrawCalculator;
use App\FeeCalculator\DepositFeeCalculator;
use App\FeeCalculator\PrivateWithdrawCalculator;

return [
    'baseCurrency' => env('FEE_CALCULATOR_BASE_CURRENCY', 'EUR'),
    'calculators' => [
        PrivateWithdrawCalculator::class,
        BusinessWithdrawCalculator::class,
        DepositFeeCalculator::class
    ],

];
