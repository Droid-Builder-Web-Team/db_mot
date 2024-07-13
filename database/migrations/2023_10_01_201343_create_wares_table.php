<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'wares', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->foreignId('user_id')->constrained();
                $table->string('type');
                $table->string('title');
                $table->text('description');
                $table->boolean('state');
                $table->boolean('showemail');
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
        Schema::dropIfExists('wares');
    }
}
