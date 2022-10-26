<?php
namespace App\Enums;

enum DiscountConditionRule: int
{
    case EQUAL = 1;
    case LESS_THAN = 2;
    case LESS_THAN_OR_EQUAL = 3;
    case GREATER_THAN = 4;
    case GREATER_THAN_OR_EQUAL = 5;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::EQUAL => 'Equal',
            self::LESS_THAN => 'Less Than',
            self::LESS_THAN_OR_EQUAL => 'Less Than or Equal',
            self::GREATER_THAN => 'Greater Than',
            self::GREATER_THAN_OR_EQUAL => 'Greater Than or Equal',
        };
    }
}
