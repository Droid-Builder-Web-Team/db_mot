<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'locations', function (Blueprint $table) {
                $table->integer('id', true);
                $table->unsignedBigInteger('ratings_id')->nullable();
                $table->string('name', 60);
                $table->string('street', 60)->nullable();
                $table->string('town', 60)->nullable();
                $table->string('county', 60)->nullable();
                $table->string('postcode', 10)->nullable();
                $table->text('other_details')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
