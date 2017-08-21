<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankerFlightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banker_flight', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('flightable_type');
            $table->unsignedInteger('flightable_id');
            $table->bigInteger('debit');
            $table->bigInteger('credit');
            $table->string('type', 10)->nullable();
            $table->text('description')->nullable();
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
        Schema::drop('banker_flight');
    }
}
