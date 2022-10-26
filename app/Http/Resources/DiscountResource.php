<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'condition_type' => $this->condition_type,
            'condition_rule' => $this->condition_rule,
            'condition_value' => $this->condition_value,
            'buy' => $this->buy,
            'get' => $this->get,
        ];
    }
}
