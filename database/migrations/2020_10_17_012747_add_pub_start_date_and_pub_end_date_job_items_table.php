<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPubStartDateAndPubEndDateJobItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_items', function (Blueprint $table) {
            $table->unsignedInteger('pub_start_flag')->default(0)->after('pub_end');
            $table->unsignedInteger('pub_end_flag')->default(0)->after('pub_start_flag');
            $table->date('pub_start_date')->nullable()->after('pub_start_flag');
            $table->date('pub_end_date')->nullable()->after('pub_end_flag');
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
            $table->dropColumn(['pub_start_flag', 'pub_end_flag', 'pub_start_date', 'pub_end_date']);
        });
    }
}
