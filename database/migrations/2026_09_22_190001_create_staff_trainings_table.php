<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('training_id')->nullable(); // Foreign key to staff_training_courses
            $table->string('title')->nullable(); // Title/Name if custom or course title
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('duration')->nullable(); // e.g. "7 Days", "1 Month"
            $table->string('institute')->nullable(); // e.g. BPATC, NAEM
            $table->string('location')->nullable(); // e.g. Dhaka, Foreign country
            $table->string('result_grade')->nullable(); // e.g. A+, Passed, Completed
            $table->string('certificate_file')->nullable(); // Uploaded file path
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('training_id')->references('id')->on('staff_training_courses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_trainings');
    }
};
