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
        Schema::create('event_views', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('event_id');
            $table->timestamp('last_viewed_at')->useCurrent();
            $table->primary(['user_id', 'event_id']);
            $table->index('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_views');
    }
};
