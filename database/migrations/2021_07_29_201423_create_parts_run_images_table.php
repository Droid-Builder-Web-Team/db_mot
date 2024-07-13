<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsRunImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'parts_run_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parts_run_data_id');
                $table->string('filename');
                $table->string('filetype');
                $table->timestamps();

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
        Schema::dropIfExists('parts_run_images');
    }
}
