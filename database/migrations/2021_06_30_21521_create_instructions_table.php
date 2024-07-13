<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'instructions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parts_run_data_id');
                $table->string('filename')->nullable();
                $table->string('filetype')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('parts_run_data_id')->references('id')->on('parts_run_data');
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
        Schema::dropIfExists('instructions');
    }
}