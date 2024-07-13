<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'mot_details', function (Blueprint $table) {
                $table->integer('mot_uid');
                $table->string('mot_test', 32);
                $table->string('mot_test_result', 5);
                $table->integer('mot_detail_uid', true);
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
        Schema::dropIfExists('mot_details');
    }
}
