<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->dropColumn([
                'last_name', 'first_name', 'postcode', 'prefecture',
                'city', 'gender', 'age', 'phone1', 'phone2', 'phone3',
                'occupation', 'final_education', 'work_start_date', 'desired_salary',
                'job_msg', 'job_q1', 'job_q2', 'job_q3'
            ]);
            $table->unsignedInteger('job_item_id')->index();
            $table->foreign('job_item_id')->references('id')->on('job_items');
            $table->unsignedInteger('s_recruit_status')->default(0);
            $table->unsignedInteger('e_recruit_status')->default(0);
            $table->unsignedInteger('congrats_amount')->default(0);
            $table->unsignedInteger('congrats_status')->default(0);
            $table->date('s_first_attendance')->nullable();
            $table->text('s_nofirst_attendance')->nullable();
            $table->date('e_first_attendance')->nullable();
            $table->text('e_nofirst_attendance')->nullable();
            $table->unsignedInteger('recruitment_fee')->default(0);
            $table->unsignedInteger('recruitment_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->string('last_name');
            $table->string('first_name');
            $table->string('postcode')->comment('郵便番号');
            $table->string('prefecture')->comment('都道府県');
            $table->string('city')->comment('市町村');
            $table->string('gender');
            $table->string('age');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('phone3');
            $table->string('occupation');
            $table->string('final_education')->comment('最終学歴');
            $table->string('work_start_date')->comment('勤務開始可能日');
            $table->string('desired_salary')->comment('希望年収')->nullable();
            $table->text('job_msg')->comment('志望動機')->nullable();
            $table->text('job_q1')->nullable();
            $table->text('job_q2')->nullable();
            $table->text('job_q3')->nullable();
            $table->dropColumn([
                'job_item_id', 's_recruit_status', 'e_recruit_status', 'congrats_amount',
                'congrats_status', 's_first_attendance', 's_nofirst_attendance', 'e_first_attendance',
                'e_nofirst_attendance', 'recruitment_fee', 'recruitment_status'
            ]);
        });
    }
}
