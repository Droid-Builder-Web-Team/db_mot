<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->text('forename');
            $table->text('surname');
            $table->char('county', 50);
            $table->char('postcode', 50);
            $table->char('latitude', 16);
            $table->char('longitude', 16);
            $table->text('email');
            $table->char('username', 25);
            $table->date('pli_date');
            $table->boolean('pli_active');
            $table->boolean('active');
            $table->integer('created_by');
            $table->string('password');
            $table->boolean('force_password');
            $table->string('gdpr_accepted');
            $table->timestamp('last_login',0);
            $table->char('last_login_from', 16);
            $table->string('badge_id');
            $table->text('remember_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
