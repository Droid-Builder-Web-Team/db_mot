<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToPartsrunInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'members_parts', function (Blueprint $table) {
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::table(
            'partsrun_interest', function (Blueprint $table) {
                //
            }
        );
    }
}
