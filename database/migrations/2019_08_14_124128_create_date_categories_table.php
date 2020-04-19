<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes(); 
            $table->timestamps();
        });
        Schema::dropIfExists('date_cats');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_categories');
        
    }
}
