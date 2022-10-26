<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->integer('condition_type'); // 1=total, 2=category, 3=product
            $table->unsignedInteger('condition_rule'); // 1=more than, 2=less than, 3=equal to
            $table->unsignedInteger('condition_value')->nullable(); // category_id, product_id

            $table->integer('type'); // 1=percentage, 2=fixed amount, 3=free product
            $table->unsignedInteger('apply_type'); // 1=total, 2=product
            $table->unsignedInteger('buy');
            $table->unsignedInteger('get');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
