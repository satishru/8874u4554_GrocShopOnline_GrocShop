<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category', function (Blueprint $table) {
            $table->bigIncrements('sub_category_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->string('sub_category_name',500);
            $table->string('sub_category_description')->nullable();
            $table->string('sub_category_image')->nullable();
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
        Schema::dropIfExists('sub_category');
    }
}
