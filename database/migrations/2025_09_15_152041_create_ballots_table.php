<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(false);
        });

        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ballot_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ballot_id')->constrained();
            $table->foreignId('candidate_id')->constrained();
            $table->timestamps();
        });

        // Log that someone voted, not that who they voted for
        Schema::create('voter_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ballot_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();

            $table->unique(['ballot_id', 'user_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ballots');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('voter_log');
    }
};
