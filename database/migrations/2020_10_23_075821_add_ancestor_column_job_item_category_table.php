<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAncestorColumnJobItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_item_category', function (Blueprint $table) {
            $table->string('parent_slug')->nullable()->after('ancestor_slug');
            $table->unsignedInteger('parent_id')->nullable()->after('ancestor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_item_category', function (Blueprint $table) {
            $table->renameColumn('parent_id', 'parent_slug');
        });
    }
}
