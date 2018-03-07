<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_user', function (Blueprint $table) {
        	    $table->increments('id');
        	    $table->unsignedInteger('user_id');
        	    $table->unsignedInteger('message_id');
        	    $table->tinyInteger('status')->nullable()->default(0);

        	    $table->foreign('user_id')
		            ->references('id')
		            ->on('users');

        	    $table->foreign('message_id')
		            ->references('id')
		            ->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_user');
    }
}
