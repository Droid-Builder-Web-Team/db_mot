<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->integer('config_uid', true);
            $table->string('email_treasurer', 50);
            $table->string('email_mot', 50);
            $table->string('site_base', 50);
            $table->string('paypal_link', 50);
            $table->string('paypal_email', 50);
            $table->integer('primary_cost');
            $table->integer('other_cost');
            $table->string('google_map_api', 48)->nullable();
            $table->string('course_api', 36)->nullable();
            $table->text('from_email');
            $table->integer('site_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
