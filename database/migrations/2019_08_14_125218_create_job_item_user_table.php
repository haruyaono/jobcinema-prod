<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobItemUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_item_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_item_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employer_id');
            $table->unsignedInteger('s_status')->nullable();
            $table->unsignedInteger('e_status')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('postcode')->comment('郵便番号');
            $table->string('prefecture')->comment('都道府県');
            $table->string('city')->comment('市町村');
            $table->string('gender');
            $table->string('age');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('phone3');
            $table->string('occupation');
            $table->string('final_education')->comment('最終学歴');
            $table->string('work_start_date')->comment('勤務開始可能日');
            $table->string('desired_salary')->comment('希望年収')->nullable();
            $table->text('job_msg')->comment('志望動機')->nullable();
            $table->text('job_q1')->nullable();
            $table->text('job_q2')->nullable();
            $table->text('job_q3')->nullable();
            $table->string('oiwaikin')->nullable();
            $table->string('oiwaikin_status')->nullable();
            $table->string('first_attendance')->nullable();
            $table->text('no_first_attendance')->nullable();
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
        Schema::dropIfExists('job_item_user');
    }
}
