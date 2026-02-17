<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilmapplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmapplications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('producer_id');
            $table->string('desk');
            $table->string('state');
            $table->integer('balance');
            $table->string('film_title');
            $table->string('applicant_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('permanent_address');
            $table->string('present_address');
            $table->string('nid_number');
            $table->string('phone_number');
            $table->string('email');
            $table->string('organization_name');
            $table->string('organization_address');
            $table->string('organization_phone');
            $table->string('organization_email');
            $table->string('bank_account_info');
            $table->string('film_serial_no');
            $table->string('production_start_date');
            $table->string('budget_amount');
            $table->string('service_type');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('film_duration');
            $table->string('equipment_rental');
            $table->string('editing');
            $table->string('color_grading');
            $table->string('vfx');
            $table->string('digital_camera');
            $table->string('digital_lab');
            $table->string('film_type');
            $table->string('org_type');
            $table->string('banner_name');
            $table->string('freedom_film_info');
            $table->string('previous_films_info');
            $table->string('board_member_status');
            $table->string('director_name');
            $table->string('director_nid');
            $table->string('cameraman_name');
            $table->string('main_cast');
            $table->string('foreign_participation');
            $table->string('script_writer_name');
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
        Schema::drop('filmapplications');
    }
}
