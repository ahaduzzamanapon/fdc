<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProducersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('organization_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('bank_name');
            $table->string('bank_branch');
            $table->string('bank_account_number');
            $table->text('bank_attachment');
            $table->string('tin_number');
            $table->string('trade_license');
            $table->string('vat_registration_number');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('nominee_nid');
            $table->text('nominee_photo');
            $table->text('partnership_agreement');
            $table->text('ltd_company_agreement');
            $table->text('somobay_agreement');
            $table->text('other_attachment');
            $table->date('trade_license_validity_date');
            $table->text('trade_license_attachment');
            $table->text('vat_attachment');
            $table->text('tin_attachment');
            $table->string('status');
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
        Schema::drop('producers');
    }
}
