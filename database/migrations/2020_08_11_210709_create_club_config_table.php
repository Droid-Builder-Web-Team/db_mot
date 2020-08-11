<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_config', function (Blueprint $table) {
            $table->integer('club_uid', true);
            $table->string('name', 32);
            $table->string('shortname', 16);
            $table->string('website', 32)->nullable();
            $table->string('facebook', 64)->nullable();
            $table->string('contact_email', 64)->nullable();
            $table->integer('options')->default(0);
            $table->string('paypal_link', 32)->nullable();
            $table->string('paypal_email', 32)->nullable();
            $table->string('font_name', 16)->default('Arial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_config');
    }
}
