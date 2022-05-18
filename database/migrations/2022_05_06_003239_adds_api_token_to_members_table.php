<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsApiTokenToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('api_token', 60)->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['api_token']);
        });
    }
}
