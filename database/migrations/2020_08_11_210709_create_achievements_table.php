<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->integer('achievement_uid', true);
            $table->string('name', 60);
            $table->text('description');
            $table->timestamp('date_created')->useCurrent();
            $table->timestamp('date_updated')->useCurrent();
            $table->binary('image')->nullable();
            $table->binary('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
