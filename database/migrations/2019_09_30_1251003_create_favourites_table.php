<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_item_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unique(array('job_item_id', 'user_id'));
            $table->timestamps();
        });
        Schema::table('favourites', function (Blueprint $table) {
            $table->foreign('job_item_id')->references('id')->on('job_items')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}
