<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyJobItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_job_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id')->index();
            $table->foreign('apply_id')->references('id')->on('applies');
            $table->unsignedInteger('job_item_id')->index();
            $table->foreign('job_item_id')->references('id')->on('job_items');
            $table->unsignedInteger('s_status')->default(0);
            $table->unsignedInteger('e_status')->default(0);
            $table->string('oiwaikin')->nullable();
            $table->string('oiwaikin_status')->default(0);
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
        Schema::dropIfExists('apply_job_item');
    }
}
