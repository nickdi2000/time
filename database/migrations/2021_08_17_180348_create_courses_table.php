<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
						$table->string("city")->nullable();
						$table->string("province")->nullable();
						$table->string("name");
						$table->string("color");
						$table->string("code")->nullable();
						$table->string("address")->nullable();
						$table->string("locality")->nullable();
						$table->string("country")->nullable();
						$table->string("administrative_area_level_1")->nullable();
						$table->string("route")->nullable();
						$table->string("street_number")->nullable();
						$table->decimal("longitude", 22, 13)->nullable();
						$table->decimal("latitude", 22, 13)->nullable();
						$table->integer('created_by')->nullable()->default(0);
						$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
