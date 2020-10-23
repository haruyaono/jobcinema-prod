<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSlugJobItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_item_category', function (Blueprint $table) {
            $table->renameColumn('slug', 'ancestor_slug');
            $table->renameColumn('parent_id', 'ancestor_id');
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
            $table->renameColumn('ancestor_slug', 'slug');
            $table->renameColumn('ancestor_id', 'parent_id');
        });
    }
}
