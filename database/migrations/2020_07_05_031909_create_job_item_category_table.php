<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_item_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_item_id')->index();
            $table->foreign('job_item_id')->references('id')->on('job_items');
            $table->unsignedInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('job_item_category');
    }
}
