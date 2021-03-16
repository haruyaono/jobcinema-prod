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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('postcode')->nullable();
            $table->string('prefecture')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('occupation')->nullable();
            $table->string('final_education')->comment('最終学歴')->nullable();
            $table->string('work_start_date')->comment('勤務開始可能日')->nullable();
            $table->timestamps();
        });
        Schema::table('profiles', function (Blueprint $table) {
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
        Schema::dropIfExists('profiles');
    }
}
