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
        Schema::create('decade_film_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('film_name')->nullable();
            $table->string('producer_name')->nullable();
            $table->string('director_name')->nullable();
            $table->text('acting')->nullable();
            $table->string('type')->nullable();
            $table->string('release_date')->nullable();
            $table->text('achivements')->nullable();
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
        Schema::dropIfExists('decade_film_lists');
    }
};
