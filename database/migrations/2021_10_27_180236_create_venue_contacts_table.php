<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venue_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('locations_id');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_number');
            $table->string('notes');
            $table->timestamps();

            // Foreign Key
            $table->foreign('locations_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venue_contacts');
    }
}
