<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employer_id');
            $table->string('cname')->comment('会社名');
            $table->string('cname_katakana')->comment('会社名（フリガナ）')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('postcode')->comment('郵便番号')->nullable();
            $table->string('prefecture')->comment('都道府県')->nullable();
            $table->string('address')->comment('住所')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('industry')->comment('業種')->nullable();
            $table->text('description')->comment('事業内容')->nullable();
            $table->string('foundation')->comment('設立')->nullable();
            $table->string('ceo')->comment('代表者様')->nullable();
            $table->string('capital')->comment('資本金')->nullable();
            $table->string('employee_number')->comment('従業員数')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
