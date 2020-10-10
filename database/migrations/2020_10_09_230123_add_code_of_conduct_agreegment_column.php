<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeOfConductAgreegmentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         if (!Schema::hasColumn('members', 'accepted_coc')) {
             Schema::table('members', function (Blueprint $table) {
                 $table->boolean('accepted_coc')->default(0);
             });
         }
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         if (Schema::hasColumn('members', 'accepted_coc')) {
             Schema::table('members', function (Blueprint $table) {
                 $table->dropColumn('accepted_coc');
             });
         }
     }
}
