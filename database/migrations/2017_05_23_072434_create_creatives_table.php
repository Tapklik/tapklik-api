<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creatives', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('folder_id');
            $table->string('uuid')->unique()->nullable();
            $table->string('name');            
            $table->string('class');
            $table->integer('h');
            $table->integer('w');
            $table->integer('expdir');
            $table->tinyinteger('responsive')->default(0);            
            $table->text('adm');
            $table->string('ctrurl');
            $table->string('iurl');
            $table->integer('type')->nullable()->default(0);
            $table->smallInteger('pos')->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('folder_id')
                ->references('id')
                ->on('folders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	    Schema::table('creatives', function (Blueprint $table) {
    		    $table->dropForeign('creatives_folder_id_foreign');

	    });
    }
}
