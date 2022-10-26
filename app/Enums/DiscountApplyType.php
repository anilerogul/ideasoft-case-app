<?php
namespace App\Enums;

enum DiscountApplyType: int
{
    case TOTAL = 1;
    case PRODUCT = 2;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::TOTAL => 'Total',
            self::PRODUCT => 'Product',
        };
    }
}
