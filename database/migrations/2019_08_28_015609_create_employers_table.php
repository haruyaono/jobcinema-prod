<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('last_name_katakana')->nullable();
            $table->string('first_name_katakana')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('email_verified')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('email_verify_token')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('employers');
    }
}
