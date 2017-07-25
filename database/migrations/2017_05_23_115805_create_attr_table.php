<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creative_id');
            $table->integer('attr')->default(0);
            $table->timestamps();

            $table->foreign('creative_id')
                  ->references('id')
                  ->on('creatives')
                  ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attr');
    }
}
