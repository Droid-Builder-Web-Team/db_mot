<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mot_lines', function (Blueprint $table) {
            $table->integer('club_uid');
            $table->integer('line_uid', true);
            $table->string('test_name', 32);
            $table->text('test_description');
            $table->text('test_long_description')->nullable();
            $table->string('test_section', 16);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mot_lines');
    }
}
