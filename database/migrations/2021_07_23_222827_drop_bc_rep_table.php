<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBcRepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bc_rep', function (BluePrint $table) {
            $table->dropIndex(['bc_rep_user_id_foreign']);
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('bc_rep');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bc_rep');

    }
}
