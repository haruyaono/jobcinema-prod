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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_item_id')->index();
            $table->foreign('job_item_id')->references('id')->on('job_items')->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedInteger('ancestor_id');
            $table->string('ancestor_slug');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('parent_slug')->nullable();
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
