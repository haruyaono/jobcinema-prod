<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixJobItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_items', function (Blueprint $table) {
            $table->unsignedInteger('status')->nullable(false)->default(0)->change();
            $table->unsignedInteger('status')->change();
            $table->index('company_id');
            $table->dropColumn(['employer_id', 'oiwaikin']);
            $table->foreign('company_id')
                ->references('id')->on('companies');
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
            $table->unsignedInteger('status')->nullable()->change();
            $table->dropForeign('job_items_company_id_foreign');
            $table->dropIndex('job_items_company_id_index');
            $table->unsignedInteger('employer_id');
            $table->string('oiwaikin')->nullable();
        });
    }
}
