<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsRunAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts_run_ad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parts_run_data_id');
            $table->string('title');
            $table->text('description');
            $table->longText('history');
            $table->decimal('price', 65, 2);
            $table->string('includes');
            $table->unsignedBigInteger('instructions_id');
            $table->string('location');
            $table->json('shipping_costs');
            $table->string('purchase_url');
            $table->string('contact_email');
            $table->timestamps();
            $table->softDeletes();

            /**
             * Foreign Keys
             */
            $table->foreign('parts_run_data_id')->references('id')->on('parts_run_data');
            $table->foreign('instructions_id')->references('id')->on('instructions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts_run_ad');
    }
}
