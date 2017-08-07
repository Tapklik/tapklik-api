<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankerMainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banker_main', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('mainable_type');
            $table->unsignedInteger('mainable_id');
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
        Schema::drop('banker_main');
    }
}
