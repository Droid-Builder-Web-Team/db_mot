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
        Schema::create(
            'assets', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->text('title');
                $table->text('description');
                $table->foreignId('user_id')->constrained();
                $table->foreignId('current_holder_id')->constrained();
                $table->date('added');
                $table->string('current_state');
                $table->string('type');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
