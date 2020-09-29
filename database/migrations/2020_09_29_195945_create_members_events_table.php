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
            $table->integer('id', true);
            $table->integer('event_id');
            $table->timestamp('date_added')->useCurrent();
            $table->integer('added_by')->nullable();
            $table->integer('user_id');
            $table->text('details')->nullable();
            $table->string('spotter', 3)->nullable();
            $table->tinyInteger('attended')->default(0);
            $table->text('status');
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
