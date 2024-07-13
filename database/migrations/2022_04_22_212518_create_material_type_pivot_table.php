<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'material_type', function (Blueprint $table) {
                $table->unsignedBigInteger('material_id')->index();
                $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
                $table->unsignedBigInteger('type_id')->index();
                $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
                $table->primary(['material_id', 'type_id']);
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
        Schema::dropIfExists('material_type');
    }
}
