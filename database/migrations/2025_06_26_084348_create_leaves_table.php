<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeavesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('total_day');
            $table->date('approved_from_date');
            $table->date('approved_to_date');
            $table->integer('approved_total_day');
            $table->text('remark');
            $table->text('status');
            $table->integer('approver_id');
            $table->text('approver_remark');
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
        Schema::drop('leaves');
    }
}
