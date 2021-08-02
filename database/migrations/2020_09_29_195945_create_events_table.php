<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('description');
            $table->integer('location_id');
            $table->text('forum_link')->nullable();
            $table->text('report_link')->nullable();
            $table->date('date');
            $table->float('charity_raised', 10, 0)->default(0);
            $table->boolean('public');
            $table->boolean('mot');
            $table->text('url')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
