<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class)->except('update');

Route::apiResource('discounts', DiscountController::class)->except('update');

Route::get('discounts/{order}/calculate', [DiscountController::class, 'calculate']);
