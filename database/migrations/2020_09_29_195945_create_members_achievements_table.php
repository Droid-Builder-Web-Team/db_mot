<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_achievements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('achievement_id');
            $table->text('notes')->nullable();
            $table->timestamp('date_added')->useCurrent();
            $table->integer('added_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_achievements');
    }
}
