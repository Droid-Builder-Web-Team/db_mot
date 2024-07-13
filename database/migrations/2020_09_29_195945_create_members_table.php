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
        Schema::create(
            'members', function (Blueprint $table) {
                $table->integer('id', true);
                $table->text('forename')->nullable();
                $table->text('surname')->nullable();
                $table->string('county', 50)->nullable();
                $table->string('postcode', 50)->nullable();
                $table->string('latitude', 16)->nullable();
                $table->string('longitude', 16)->nullable();
                $table->text('email');
                $table->string('username', 25)->nullable();
                $table->date('pli_date')->nullable();
                $table->string('pli_active', 5)->nullable();
                $table->string('active', 3)->default('on');
                $table->timestamp('created_on')->useCurrent();
                $table->integer('created_by')->default(0);
                $table->timestamp('last_updated')->nullable()->useCurrent();
                $table->string('password', 60)->nullable();
                $table->integer('force_password')->default(0);
                $table->integer('gdpr_accepted')->default(0);
                $table->timestamp('last_login')->nullable();
                $table->string('last_login_from', 16)->nullable();
                $table->text('badge_id')->nullable();
                $table->date('join_date')->nullable();
                $table->text('remember_token')->nullable();
                $table->dateTime('email_verified_at')->nullable();
                $table->dateTime('last_activity')->nullable();
                $table->tinyInteger('accepted_gdpr')->nullable();
                $table->tinyInteger('isAnonymized')->default(0);
                $table->json('settings')->nullable();
            }
        );
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
