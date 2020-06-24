<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('sub_sub_category_id');
            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->foreign('sub_category_id')->references('sub_category_id')->on('sub_category');
            $table->foreign('sub_sub_category_id')->references('sub_sub_category_id')->on('sub_sub_category');
            $table->string('product_name',500);
            $table->text('product_description');
            $table->string('product_image',500);
            $table->integer('items_in_stock')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('in_stock')->default(1);
            $table->tinyInteger('is_daily_essential')->default(0);
            $table->tinyInteger('is_top_selling')->default(0);
            $table->string('meta_tag',200)->nullable();
            $table->string('meta_desc',500)->nullable();
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
        Schema::dropIfExists('product');
    }
}
