<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('employer_id');
            $table->unsignedInteger('status')->nullable();
            $table->string('oiwaikin')->nullable();
            $table->string('slug');
            $table->string('job_title')->nullable();
            $table->string('job_img')->nullable();
            $table->string('job_img2')->nullable();
            $table->string('job_img3')->nullable();
            $table->string('job_mov')->nullable();
            $table->string('job_mov2')->nullable();
            $table->string('job_mov3')->nullable();
            $table->string('job_type')->nullable();
            $table->text('job_hourly_salary')->nullable();
            $table->string('job_office')->comment('勤務先の企業名・店舗名')->nullable();
            $table->text('job_office_address')->comment('勤務先の住所')->nullable();
            $table->text('job_desc')->nullable();
            $table->text('job_intro')->nullable();
            $table->text('salary_increase')->comment('昇給・賞与')->nullable();
            $table->text('job_time')->nullable();
            $table->text('job_target')->nullable();
            $table->text('job_treatment')->nullable();
            $table->string('pub_start')->nullable();
            $table->string('pub_end')->nullable();
            $table->text('remarks')->nullable();
            $table->string('job_q1')->nullable();
            $table->string('job_q2')->nullable();
            $table->string('job_q3')->nullable();
            $table->unsignedInteger('status_cat_id');
            $table->unsignedInteger('type_cat_id');
            $table->unsignedInteger('area_cat_id');
            $table->unsignedInteger('hourly_salary_cat_id');
            $table->unsignedInteger('date_cat_id')->nullable();
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
        Schema::dropIfExists('job_items');
    }
}
