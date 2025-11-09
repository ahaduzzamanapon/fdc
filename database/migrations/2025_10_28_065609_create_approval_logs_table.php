<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApprovalLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('action_by');
            $table->integer('action_role_id');
            $table->string('action');
            $table->text('remarks');
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
        Schema::drop('approval_logs');
    }
}
