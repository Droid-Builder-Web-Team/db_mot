<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsRunDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'parts_run_data', function (Blueprint $table) {
                $table->id();
                $table->integer('club_id');
                $table->integer('user_id');
                $table->integer('bc_rep_id');
                $table->string('status');
                $table->timestamps();
                $table->softDeletes();

                /**
                 * Foreign Keys
                 */
                $table->foreign('user_id')->references('id')->on('members');
                $table->foreign('bc_rep_id')->references('id')->on('members');
                $table->foreign('club_id')->references('id')->on('clubs');
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
        Schema::dropIfExists('parts_run_data');
    }
}
