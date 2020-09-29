<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_runs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('run_type')->default(1);
            $table->integer('user_id');
            $table->integer('droid_id');
            $table->integer('first_half');
            $table->integer('second_half');
            $table->integer('clock_time');
            $table->integer('final_time');
            $table->integer('num_penalties')->default(0);
            $table->text('penalties')->nullable();
            $table->integer('dribble')->default(0);
            $table->dateTime('run_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_runs');
    }
}
