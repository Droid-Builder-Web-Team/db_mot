<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mot', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('droid_id')->index('droid_uid');
            $table->date('date');
            $table->text('location');
            $table->string('mot_type', 10)->default('Initial');
            $table->string('approved', 15);
            $table->integer('user');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mot');
    }
}
