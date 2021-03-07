<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AchieveRewardBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achieve_reward_billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apply_id')->index();
            $table->foreign('apply_id')->references('id')->on('applies');
            $table->boolean('is_payed')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->boolean('is_return_requested')->nullable();
            $table->timestamp('return_requested_at')->nullable();
            $table->boolean('is_returned')->nullable();
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
        Schema::dropIfExists('achieve_reward_billing');
    }
}
