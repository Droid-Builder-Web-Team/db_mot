<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDroidTypeToClubId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts_run_data', function (Blueprint $table) {
            $table->dropForeign(['droid_type_id']);
            $table->dropColumn('droid_type_id');

            $table->integer('club_id')->after('user_id');

            $table->foreign('club_id')->references('id')->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts_run_data', function (Blueprint $table) {
            //
        });
    }
}
