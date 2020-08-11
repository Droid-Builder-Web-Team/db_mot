<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePliCoverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pli_cover_details', function (Blueprint $table) {
            $table->integer('uid', true);
            $table->text('details');
            $table->text('body');
            $table->string('contact1', 50);
            $table->string('contact2', 50);
            $table->binary('logo');
            $table->text('footer_text');
            $table->text('header_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pli_cover_details');
    }
}
