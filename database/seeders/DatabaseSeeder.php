<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(10)->create();
        Customer::factory()->count(10)->create();
        Product::factory()->count(50)->create();

        Order::factory()->count(5)->create()->each(function (Order $order) {
            $orderTotal = 0;

            $order->items()->saveMany(
                Product::inRandomOrder()->limit(rand(1, 5))->get()->map(function (Product $product) use (&$orderTotal) {
                    $orderTotal += $total = $product->price * $quantity = rand(1, 5);

                    return new OrderItem([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $product->price,
                        'total' => $total,
                    ]);
                })
            );

            $order->update(['total' => $orderTotal]);
        });
    }
}
