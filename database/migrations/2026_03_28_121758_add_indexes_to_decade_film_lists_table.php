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
        Schema::table('decade_film_lists', function (Blueprint $table) {
            // Supports fast year prefix filtering and default release-date sorting.
            $table->index(['release_date', 'id'], 'dfl_release_date_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('decade_film_lists', function (Blueprint $table) {
            $table->dropIndex('dfl_release_date_id_idx');
        });
    }
};
