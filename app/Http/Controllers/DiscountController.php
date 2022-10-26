<?php
namespace App\Http\Controllers;

use App\Http\Requests\Discount\StoreRequest;
use App\Http\Resources\DiscountCalculateResource;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Models\Order;
use App\Support\DiscountManager;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::latest()->get();

        return DiscountResource::collection($discounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();

        $discount = Discount::create($attributes);

        return DiscountResource::make($discount);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        return DiscountResource::make($discount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return DiscountResource::make();
    }

    public function calculate(Order $order)
    {
        $discountResponse = app(DiscountManager::class)->calculate($order);

        return DiscountCalculateResource::make($discountResponse);
    }
}
