<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('droid_invites', function (Blueprint $table) {
            $table->id();
            $table->integer('droid_id')->index();
            $table->integer('invited_by');
            $table->integer('invited_user_id')->nullable()->index();
            $table->string('email');
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('droid_invites');
    }
};
