<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_events', function (Blueprint $table) {
            $table->integer('uid', true);
            $table->integer('event_uid');
            $table->timestamp('date_added')->useCurrent();
            $table->integer('added_by');
            $table->integer('member_uid');
            $table->string('spotter', 3)->nullable();
            $table->tinyInteger('attended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_events');
    }
}
