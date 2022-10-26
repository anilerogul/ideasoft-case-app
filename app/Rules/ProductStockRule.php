<?php
namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ProductStockRule implements Rule
{
    public $items;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = Arr::first($this->items, fn ($item) => $item['product_id'] === $value);

        return Product::where('id', $value)->where('stock', '>=', $item['quantity'])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The product stock is not enough.';
    }
}
