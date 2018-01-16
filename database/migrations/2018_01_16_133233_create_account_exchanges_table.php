<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identifier');
            $table->string('name');
            $table->string('endpoint');
            $table->integer('seatId');
            $table->integer('billingId');
            $table->string('token')->nullable();
            $table->string('prefix')->nullable();
            $table->string('postfix')->nullable();
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
        Schema::dropIfExists('account_exchanges');
    }
}
