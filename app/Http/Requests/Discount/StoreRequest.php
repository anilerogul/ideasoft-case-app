<?php
namespace App\Http\Requests\Discount;

use App\Enums\DiscountApplyType;
use App\Enums\DiscountConditionRule;
use App\Enums\DiscountConditionType;
use App\Enums\DiscountType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|int|in:' . $this->getTypeValues(DiscountType::cases()),
            'condition_type' => 'required|int|in:' . $this->getTypeValues(DiscountConditionType::cases()),
            'condition_rule' => 'required|int|int:' . $this->getTypeValues(DiscountConditionRule::cases()),
            'condition_value' => 'sometimes|nullable|int',
            'apply_type' => 'required|int|in:' . $this->getTypeValues(DiscountApplyType::cases()),
            'buy' => 'required|int',
            'get' => 'required|int'
        ];
    }

    /**
     * @param array $types
     * @return string
     */
    protected function getTypeValues(array $types): string
    {
        return collect($types)->map->value->implode(',');
    }
}
