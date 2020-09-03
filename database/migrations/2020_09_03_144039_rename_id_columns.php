<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievements', function(Blueprint $table)
          {
            $table->renameColumn('achievement_uid', 'id');
          });

        Schema::table('clubs', function(Blueprint $table)
          {
            $table->renameColumn('club_uid', 'id');
          });

        Schema::table('droids', function(Blueprint $table)
          {
            $table->renameColumn('droid_uid', 'id');
            $table->renameColumn('club_uid', 'club_id');
          });

        Schema::table('droid_members', function(Blueprint $table)
          {
            $table->renameColumn('member_uid', 'user_id');
            $table->renameColumn('droid_uid', 'droid_id');
          });

        Schema::table('events', function(Blueprint $table)
          {
            $table->renameColumn('event_uid', 'id');
          });

        Schema::table('locations', function(Blueprint $table)
          {
            $table->renameColumn('location_uid', 'id');
          });

        Schema::table('members', function(Blueprint $table)
          {
            $table->renameColumn('member_uid', 'id');
          });

        Schema::table('members_achievements', function(Blueprint $table)
          {
            $table->renameColumn('member_uid', 'user_id');
            $table->renameColumn('achievement_uid', 'achievement_id');
          });

        Schema::table('members_events', function(Blueprint $table)
          {
            $table->renameColumn('member_uid', 'user_id');
            $table->renameColumn('event_uid', 'event_id');
            $table->renameColumn('uid', 'id');
          });

        Schema::table('mot', function(Blueprint $table)
          {
            $table->renameColumn('mot_uid', 'id');
            $table->renameColumn('droid_uid', 'droid_id');
          });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievements', function(Blueprint $table)
          {
            $table->renameColumn('id', 'achievement_uid');
          });

        Schema::table('clubs', function(Blueprint $table)
          {
            $table->renameColumn('id', 'club_uid');
          });

        Schema::table('droids', function(Blueprint $table)
          {
            $table->renameColumn('id', 'droid_uid');
          });

        Schema::table('droid_members', function(Blueprint $table)
          {
            $table->renameColumn('member_id', 'member_uid');
            $table->renameColumn('droid_id', 'droid_uid');
          });

        Schema::table('events', function(Blueprint $table)
          {
            $table->renameColumn('id', 'event_uid');
          });

        Schema::table('locations', function(Blueprint $table)
          {
            $table->renameColumn('id', 'location_uid');
          });

        Schema::table('members', function(Blueprint $table)
          {
            $table->renameColumn('id', 'member_uid');
          });

        Schema::table('members_achievements', function(Blueprint $table)
          {
            $table->renameColumn('member_id', 'member_uid');
            $table->renameColumn('achievement_id', 'achievement_uid');
          });

        Schema::table('members_events', function(Blueprint $table)
          {
            $table->renameColumn('member_id', 'member_uid');
            $table->renameColumn('event_id', 'event_uid');
            $table->renameColumn('id', 'uid');
          });

        Schema::table('mot', function(Blueprint $table)
          {
            $table->renameColumn('id', 'mot_uid');
            $table->renameColumn('droid_id', 'droid_uid');
          });



    }
}
