<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes(); 
            $table->timestamps();
        });
        Schema::dropIfExists('type_cats');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_categories');
        
    }
}
