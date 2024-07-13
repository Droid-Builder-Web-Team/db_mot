<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatlngColumnsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'locations', function (Blueprint $table) {
                $table->text('latitude')->nullable();
                $table->text('longitude')->nullable();
                $table->string('country')->default('United Kingdom');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'locations', function (Blueprint $table) {
            }
        );
    }
}
