<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeographiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geographies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('country_iso2');
            $table->string('country_name');
            $table->string('country');
            $table->string('city');
            $table->string('region');
            $table->string('region_name');
            $table->string('type');
            $table->string('comment');
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
        Schema::dropIfExists('geographies');
    }
}
