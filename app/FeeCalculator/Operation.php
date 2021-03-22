<?php


namespace App\FeeCalculator;


use Illuminate\Support\Carbon;

class Operation
{
    public string $date;
    public int $userId;
    public string $userType;
    public string $type;
    public float $amount;
    public string $currency;
    public int $weeklyCount;
    public float $weeklyAmount;

    public function __construct($date, $userId, $userType, $type, $amount, $currency)
    {
        $this->date = $date;
        $this->userId = (int)$userId;
        $this->userType = $userType;
        $this->type = $type;
        $this->amount = (float)$amount;
        $this->currency = $currency;
    }

    public static function round($number): float
    {
        return round($number, 2, PHP_ROUND_HALF_UP);
    }

    public static function getPercentsFrom(float $percentInDecimal, float $amount): float
    {
        if ($amount <= 0) {
            return 0;
        }

        return self::round(($percentInDecimal / 100) * $amount);
    }

    public function isDeposit(): bool
    {
        return 'deposit' === $this->type;
    }

    public function isWithdraw(): bool
    {
        return 'withdraw' === $this->type;
    }

    public function isPrivate(): bool
    {
        return 'private' === $this->userType;
    }

    public function isBusiness(): bool
    {
        return 'business' === $this->userType;
    }

    public function isPrivateWithdraw(): bool
    {
        return $this->isPrivate() && $this->isWithdraw();
    }

    public function isBusinessWithdraw(): bool
    {
        return $this->isBusiness() && $this->isWithdraw();
    }

    public function isOnSameWeek(Operation $operation): bool
    {
        if ($this->userId !== $operation->userId) {
            return false;
        }
        return Carbon::parse($this->date)->isSameWeek($operation->date);
    }
}
