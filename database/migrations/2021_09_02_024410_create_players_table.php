<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->decimal("longitude", 10, 7)->nullable();
            $table->decimal("latitude", 10, 7)->nullable();
            $table->integer("hole")->nullable()->default(0);
            $table->integer("course_id")->nullable();
            $table->integer("group_size")->nullable();
            $table->string("color")->nullable(); //hex color code
            $table->integer("status_id")->default(1); // 0 = cancelled, 1 = active, 2 = recieved drink


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
