<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsRunDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts_run_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('droid_type_id');
            $table->integer('user_id');
            $table->unsignedBigInteger('bc_rep_id');
            $table->string('status');
            $table->unsignedBigInteger('parts_run_ad_id');
            $table->timestamps();
            $table->softDeletes();

            /**
             * Foreign Keys
             */
            $table->foreign('droid_type_id')->references('id')->on('droid_type');
            $table->foreign('user_id')->references('id')->on('members');
            $table->foreign('bc_rep_id')->references('id')->on('bc_rep');
            $table->foreign('parts_run_ad_id')->references('id')->on('parts_run_ad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts_run_data');
    }
}