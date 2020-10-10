<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuildLogURL extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
       if (!Schema::hasColumn('droids', 'build_log')) {
           Schema::table('droids', function (Blueprint $table) {
               $table->text('build_log')->nullable();
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
       if (Schema::hasColumn('droids', 'build_log')) {
           Schema::table('droids', function (Blueprint $table) {
               $table->dropColumn('build_log');
           });
       }
   }
}
