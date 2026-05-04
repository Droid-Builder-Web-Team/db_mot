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
        Schema::table('droids', function (Blueprint $table) {
            $table->unsignedInteger('commendations')->default(0)->after('public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('droids', function (Blueprint $table) {
            $table->dropColumn('commendations');
        });
    }
};
