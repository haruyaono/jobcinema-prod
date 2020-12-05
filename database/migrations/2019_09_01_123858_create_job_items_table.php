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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('status')->default(0);
            $table->string('job_title')->nullable();
            $table->string('job_img_1')->nullable();
            $table->string('job_img_2')->nullable();
            $table->string('job_img_3')->nullable();
            $table->string('job_mov_1')->nullable();
            $table->string('job_mov_2')->nullable();
            $table->string('job_mov_3')->nullable();
            $table->string('job_type')->nullable();
            $table->text('job_salary')->nullable();
            $table->string('job_office')->comment('勤務先の企業名・店舗名')->nullable();
            $table->text('job_office_address')->comment('勤務先の住所')->nullable();
            $table->text('job_desc')->nullable();
            $table->text('job_intro')->nullable();
            $table->text('salary_increase')->comment('昇給・賞与')->nullable();
            $table->text('job_time')->nullable();
            $table->text('job_target')->nullable();
            $table->text('job_treatment')->nullable();
            $table->unsignedInteger('pub_start_flag')->default(0);
            $table->date('pub_start_date')->nullable();
            $table->unsignedInteger('pub_end_flag')->default(0);
            $table->date('pub_end_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('job_q1')->nullable();
            $table->string('job_q2')->nullable();
            $table->string('job_q3')->nullable();
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
