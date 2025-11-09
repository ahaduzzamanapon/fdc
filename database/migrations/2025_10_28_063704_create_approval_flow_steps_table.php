<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApprovalFlowStepsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_flow_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id');
            $table->integer('from_role_id');
            $table->integer('to_role_id');
            $table->integer('step_order');
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
        Schema::drop('approval_flow_steps');
    }
}
