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
            $table->integer('club_id')->index('club_uid');
            $table->integer('id', true);
            $table->string('test_name', 32);
            $table->text('test_description');
            $table->text('test_long_description')->nullable();
            $table->string('test_section', 16);
            $table->integer('section_id');
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
