<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('division');
            $table->string('category');
            $table->string('name');
            $table->string('name_ruby')->nullable();
            $table->string('c_name')->nullable();
            $table->string('c_name_ruby')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('division');
            $table->dropColumn('category');
            $table->dropColumn('name');
            $table->dropColumn('name_ruby');
            $table->dropColumn('c_name');
            $table->dropColumn('c_name_ruby');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('content');
        });
    }
}
