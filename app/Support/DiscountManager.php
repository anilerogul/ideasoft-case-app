<?php
namespace App\Support;

use App\Enums\DiscountApplyType;
use App\Enums\DiscountConditionRule;
use App\Enums\DiscountConditionType;
use App\Enums\DiscountType;
use App\Models\Discount;
use App\Models\Order;

class DiscountManager
{
    protected Order $order;
    protected float $totalDiscount = 0;
    protected float $discountedTotal = 0;
    protected array $appliedDiscounts = [];

    public function calculate(Order $order)
    {
        $this->order = $order;
        $this->discountedTotal = $order->total;


        $discounts = Discount::all();

        foreach ($discounts as $discount) {
            $this->checkCondition($discount);
        }

        return [
            'orderId' => $order->id,
            'discounts' => $this->appliedDiscounts,
            'totalDiscount' => $this->totalDiscount,
            'discountedTotal' => $this->totalDiscount > 0 ? $this->discountedTotal : 0,
        ];
    }

    protected function checkCondition(Discount $discount)
    {
        match ($discount->condition_type) {
            DiscountConditionType::TOTAL->value => $this->checkTotalCondition($discount),
            DiscountConditionType::CATEGORY->value => $this->checkCategoryCondition($discount),
        };
    }

    protected function checkTotalCondition(Discount $discount)
    {
        if ($this->checkConditionRule($discount, $this->order->total)) {
            $this->applyDiscount($discount);
        }
    }

    protected function checkCategoryCondition(Discount $discount)
    {
        $categoryProductCount = $this->order->items()
            ->whereHas('product', function ($query) use ($discount) {
                $query->where('category_id', $discount->condition_value);
            })
            ->sum('quantity');

        if ($this->checkConditionRule($discount, $categoryProductCount)) {
            $this->applyDiscount($discount);
        }
    }

    /**
     * @param \App\Models\Discount $discount
     * @param $value
     * @return boolean
     */
    protected function checkConditionRule(Discount $discount, $value): bool
    {
        return match ($discount->condition_rule) {
            DiscountConditionRule::EQUAL->value => $value == $discount->buy,
            DiscountConditionRule::LESS_THAN->value => $value < $discount->buy,
            DiscountConditionRule::LESS_THAN_OR_EQUAL->value => $value <= $discount->buy,
            DiscountConditionRule::GREATER_THAN->value => $value > $discount->buy,
            DiscountConditionRule::GREATER_THAN_OR_EQUAL->value => $value >= $discount->buy,
        };
    }

    protected function applyDiscount(Discount $discount)
    {
        $this->appliedDiscounts[] = [
            'discountReason' => $discount->name,
            'discountAmount' => $this->calculateDiscountAmount($discount),
            'subtotal' => $this->discountedTotal,
        ];
    }

    protected function calculateDiscountAmount(Discount $discount)
    {
        $amount = match ($discount->type) {
            DiscountType::PERCENTAGE->value => $this->calculatePercentageDiscount($discount),
            DiscountType::FIXED_AMOUNT->value => $this->calculateFixedAmountDiscount($discount),
            DiscountType::FREE_PRODUCT->value => $this->calculateFreeProductDiscount($discount),
        };

        return tap(round($amount, 2), function ($amount) {
            if ($amount > 0) {
                $this->totalDiscount = round($this->totalDiscount + $amount, 2);
                $this->discountedTotal = round($this->discountedTotal - $amount, 2);
            }
        });
    }

    protected function calculatePercentageDiscount(Discount $discount)
    {
        if($discount->apply_type == DiscountApplyType::TOTAL->value) {
            return $this->discountedTotal * ($discount->get / 100);
        }

        if($discount->apply_type == DiscountApplyType::PRODUCT->value) {
            return $this->order->items()->orderBy('total')->value('total') * ($discount->get / 100);
        }
    }

    protected function calculateFixedAmountDiscount(Discount $discount)
    {
        if($discount->apply_type == DiscountApplyType::TOTAL->value) {
            return ($this->discountedTotal <= $discount->get)
                ? $this->discountedTotal
                : $discount->get;
        }

        if($discount->apply_type == DiscountApplyType::PRODUCT->value) {
            $productTotal = $this->order->items()->where('total', '>=', $discount->get)->orderBy('total')->value('total');

            return ($productTotal <= $discount->get)
                ? $productTotal
                : $discount->get;
        }
    }

    protected function calculateFreeProductDiscount(Discount $discount)
    {
        if($discount->get <= 0){
            return 0;
        }


        $items = $this->order->items()
            ->orderBy('unit_price')
            ->get();

        $freeCount = 0;
        $freeProductTotal = 0;

        foreach ($items as $item) {
            if ($freeCount >= $discount->get) {
                break;
            }

            if ($discount->get >= $item->quantity) {
                $freeCount += $item->quantity;
                $freeProductTotal += $item->total;
            }else if ($discount->get < $item->quantity) {
                $freeCount += $discount->get;
                $freeProductTotal += $item->unit_price * $discount->get;
            }
        }

        return $freeProductTotal;
    }
}
