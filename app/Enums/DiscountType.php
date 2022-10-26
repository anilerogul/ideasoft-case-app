<?php
namespace App\Enums;

enum DiscountType: int
{
    case PERCENTAGE = 1;
    case FIXED_AMOUNT = 2;
    case FREE_PRODUCT = 3;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::PERCENTAGE => 'Percentage',
            self::FIXED_AMOUNT => 'Fixed Amount',
            self::FREE_PRODUCT => 'Free Product',
        };
    }
}
