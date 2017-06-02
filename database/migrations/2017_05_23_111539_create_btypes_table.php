<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('btypes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creative_id');
            $table->integer('type')->default(0);
            $table->timestamps();

            $table->foreign('creative_id')
                  ->references('id')
                  ->on('creatives')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('btypes');
    }
}
