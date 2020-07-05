<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoriesInJobItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_items', function (Blueprint $table) {
            $table->dropColumn('status_cat_id');
            $table->dropColumn('type_cat_id');
            $table->dropColumn('area_cat_id');
            $table->dropColumn('hourly_salary_cat_id');
            $table->dropColumn('date_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_items', function (Blueprint $table) {
            $table->unsignedInteger('status_cat_id');
            $table->unsignedInteger('type_cat_id');
            $table->unsignedInteger('area_cat_id');
            $table->unsignedInteger('hourly_salary_cat_id');
            $table->unsignedInteger('date_cat_id');
        });
    }
}
