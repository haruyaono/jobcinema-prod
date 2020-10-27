<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->ondelete('SET NULL');
            $table->unsignedBigInteger('job_item_id')->index();
            $table->foreign('job_item_id')->references('id')->on('job_items');
            $table->unsignedInteger('s_recruit_status')->default(0);
            $table->unsignedInteger('e_recruit_status')->default(0);
            $table->unsignedInteger('congrats_amount')->default(0);
            $table->unsignedInteger('congrats_status')->default(0);
            $table->date('s_first_attendance')->nullable();
            $table->text('s_nofirst_attendance')->nullable();
            $table->date('e_first_attendance')->nullable();
            $table->text('e_nofirst_attendance')->nullable();
            $table->unsignedInteger('recruitment_fee')->default(0);
            $table->unsignedInteger('recruitment_status')->default(0);
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
        Schema::dropIfExists('applies');
    }
}
