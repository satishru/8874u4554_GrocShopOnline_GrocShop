<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductQuantityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_quantity', function (Blueprint $table) {
            $table->bigIncrements('quantity_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->tinyInteger('items_multiplier')->default(1);
            $table->double('product_quantity', 16, 2);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('unit_id')->on('units');
            $table->double('product_price', 16, 2)->default(0);
            $table->double('product_offer_percent', 16, 2)->default(0);
            $table->string('product_with')->nullable();
            $table->tinyInteger('in_stock')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('added_by');
            $table->ipAddress('added_ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_quantity');
    }
}
