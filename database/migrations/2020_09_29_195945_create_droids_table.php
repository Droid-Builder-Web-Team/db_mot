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
            $table->integer('id', true);
            $table->text('name');
            $table->string('primary_droid', 5)->default('No');
            $table->timestamp('date_added')->useCurrent();
            $table->text('type')->nullable();
            $table->text('style')->nullable();
            $table->string('radio_controlled', 5)->nullable();
            $table->text('transmitter_type')->nullable();
            $table->text('material')->nullable();
            $table->text('weight')->nullable();
            $table->text('battery')->nullable();
            $table->text('drive_voltage')->nullable();
            $table->string('drive_type', 36)->nullable();
            $table->string('top_speed', 5)->nullable();
            $table->text('sound_system')->nullable();
            $table->text('notes')->nullable();
            $table->text('back_story')->nullable();
            $table->text('value')->nullable();
            $table->integer('topps_id')->nullable()->default(0);
            $table->string('tier_two', 5)->default('No');
            $table->string('active', 3)->default('on');
            $table->timestamp('last_updated')->useCurrent();
            $table->integer('club_id');
            $table->text('build_log')->nullable();
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
