<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('category_name',500);
            $table->string('category_description')->nullable();
            $table->string('category_image')->nullable();
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
        Schema::dropIfExists('category');
    }
}
