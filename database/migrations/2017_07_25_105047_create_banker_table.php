<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('bankerable_type');
            $table->unsignedInteger('bankerable_id');
            $table->bigInteger('debit');
            $table->bigInteger('credit');
            $table->text('description');
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
        Schema::drop('bankers');
    }
}
