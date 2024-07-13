<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePartsRunAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'parts_run_ad', function (Blueprint $table) {
                $table->string('title')->default('Title')->change();
                $table->text('description')->nullable()->change();
                $table->longText('history')->nullable()->change();
                $table->decimal('price')->default(0.00)->change();
                $table->string('includes')->default('-')->change();
                $table->json('shipping_costs')->nullable()->change();
                $table->string('instructions_url')->nullable()->change();
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
            'parts_run_ad', function (Blueprint $table) {
                //
            }
        );
    }
}
