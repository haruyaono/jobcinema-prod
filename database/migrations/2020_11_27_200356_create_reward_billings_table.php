<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_billings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('apply_id')->index();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('billing_amount')->comment('請求金額')->default(0);
            $table->dateTime('payment_date')->comment('支払日')->nullable();
            $table->timestamps();
        });
        Schema::table('reward_billings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apply_id')->references('id')->on('applies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_billings');
    }
}
