<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesAndDeleteSomeColumnsInCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->softDeletes();
            $table->dropColumn('slug');
            $table->dropColumn('cover_photo');
            $table->dropColumn('slogan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->string('slug');
            $table->string('cover_photo')->nullable();
            $table->text('slogan')->nullable();
        });
    }
}
