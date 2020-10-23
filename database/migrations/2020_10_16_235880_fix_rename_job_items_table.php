<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRenameJobItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_items', function (Blueprint $table) {
            $table->renameColumn('job_img', 'job_img_1');
            $table->renameColumn('job_img2', 'job_img_2');
            $table->renameColumn('job_img3', 'job_img_3');
            $table->renameColumn('job_mov', 'job_mov_1');
            $table->renameColumn('job_mov2', 'job_mov_2');
            $table->renameColumn('job_mov3', 'job_mov_3');
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
            $table->renameColumn('job_img_1', 'job_img');
            $table->renameColumn('job_img_2', 'job_img2');
            $table->renameColumn('job_img_3', 'job_img3');
            $table->renameColumn('job_mov_1', 'job_mov');
            $table->renameColumn('job_mov2', 'job_mov2');
            $table->renameColumn('job_mov_3', 'job_mov3');
        });
    }
}
