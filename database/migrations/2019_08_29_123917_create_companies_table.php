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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employer_id')->index();
            $table->foreign('employer_id')->references('id')->on('employers');
            $table->string('cname');
            $table->string('cname_katakana')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('postcode')->nullable();
            $table->string('prefecture')->nullable();
            $table->string('address')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('industry')->comment('業種')->nullable();
            $table->text('description')->comment('事業内容')->nullable();
            $table->string('foundation')->comment('設立')->nullable();
            $table->string('ceo')->comment('代表者様')->nullable();
            $table->string('capital')->comment('資本金')->nullable();
            $table->string('employee_number')->comment('従業員数')->nullable();
            $table->string('bank_name')->comment('銀行名')->nullable();
            $table->string('branch_name')->comment('支店名')->nullable();
            $table->string('account_type')->comment('口座タイプ')->nullable();
            $table->string('account_number')->comment('口座番号')->nullable();
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
