<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('postcode')->comment('郵便番号')->nullable();
            $table->string('prefecture')->comment('都道府県')->nullable();
            $table->string('city')->comment('市町村')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('occupation')->nullable();
            $table->string('final_education')->comment('最終学歴')->nullable();
            $table->string('work_start_date')->comment('勤務開始可能日')->nullable();
            $table->string('desired_salary')->comment('希望年収')->nullable();
            $table->string('resume')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
