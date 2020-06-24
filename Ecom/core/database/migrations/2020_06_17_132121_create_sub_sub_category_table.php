<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubSubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_sub_category', function (Blueprint $table) {
            $table->bigIncrements('sub_sub_category_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->foreign('sub_category_id')->references('sub_category_id')->on('sub_category');
            $table->string('sub_sub_category_name',500);
            $table->string('sub_sub_category_description')->nullable();
            $table->string('sub_sub_category_image')->nullable();
            $table->string('meta_tag',200)->nullable();
            $table->string('meta_desc',500)->nullable();
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
        Schema::dropIfExists('sub_sub_category');
    }
}
