<?php
namespace App\Enums;

enum DiscountConditionType: int
{
    case TOTAL = 1;
    case CATEGORY = 2;
    case PRODUCT = 3;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::TOTAL => 'Total',
            self::CATEGORY => 'Category',
            self::PRODUCT => 'Product',
        };
    }
}
