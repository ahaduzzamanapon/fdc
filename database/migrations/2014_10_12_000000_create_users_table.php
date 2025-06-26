<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn')->nullable();
            $table->string('name_en')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->enum('religion', ['Islam', 'Hindu', 'Christian', 'Buddhist', 'Others'])->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('nid')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('marital_status', ['Single', 'Married'])->nullable();
            $table->integer('no_of_child')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->unsignedBigInteger('dis_id')->nullable();
            $table->string('picture')->nullable();
            $table->string('signature')->nullable();
            $table->text('present_add')->nullable();
            $table->text('note')->nullable();
            $table->enum('employee_type', ['Officer', 'Staff'])->nullable();
            $table->date('join_date')->nullable();
            $table->string('grade')->nullable();
            $table->string('designation')->nullable();
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->enum('current_status', ['Active', 'Inactive'])->default('Active');
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
