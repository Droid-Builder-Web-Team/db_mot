<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDroidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droids', function (Blueprint $table) {
            $table->integer('droid_uid', true);
            $table->integer('member_uid');
            $table->text('name');
            $table->string('primary_droid', 5);
            $table->timestamp('date_added')->useCurrent();
            $table->text('type');
            $table->text('style');
            $table->string('radio_controlled', 5);
            $table->text('transmitter_type');
            $table->text('material');
            $table->text('weight');
            $table->text('battery');
            $table->text('drive_voltage');
            $table->string('drive_type', 36)->nullable();
            $table->string('top_speed', 5)->nullable();
            $table->text('sound_system');
            $table->text('notes')->nullable();
            $table->text('back_story')->nullable();
            $table->text('value');
            $table->integer('topps_id')->nullable()->default(0);
            $table->string('tier_two', 5)->default('No');
            $table->string('active', 3)->default('on');
            $table->timestamp('last_updated')->useCurrent();
            $table->integer('club_uid');
            $table->string('public', 3)->default('No');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droids');
    }
}
