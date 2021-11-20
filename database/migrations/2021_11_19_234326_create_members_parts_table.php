<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_parts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('parts_run_data_id');
            $table->text('status');
            $table->integer('quantity')->default(1);
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_parts');
    }
}
