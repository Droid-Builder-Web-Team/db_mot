<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDroidCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droid_comments', function (Blueprint $table) {
            $table->integer('uid', true);
            $table->integer('droid_uid');
            $table->longText('comment');
            $table->timestamp('added_on')->useCurrent();
            $table->integer('added_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droid_comments');
    }
}
