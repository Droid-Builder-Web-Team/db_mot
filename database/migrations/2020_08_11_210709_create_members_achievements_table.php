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
            $table->integer('uid', true);
            $table->integer('member_uid');
            $table->integer('achievement_uid');
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
