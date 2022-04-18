<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenusAddIcon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('menu_items', function (Blueprint $table) {
          $table->string('icon')->nullable();
          $table->integer('parent_id')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('menu_items', function (Blueprint $table) {
          $table->dropColumn(['icon']);
          $table->dropColumn(['parent_id']);
      });
    }
}
