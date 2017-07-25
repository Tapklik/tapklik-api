<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'campaigns',
            function (Blueprint $table) {

                $table->increments('id');
                $table->unsignedInteger('account_id');
                $table->string('uuid')->nullable();
                $table->string('name');
                $table->text('description')->nullable();
                $table->date('start');
                $table->date('end');
                $table->integer('bid');
                $table->string('ctrurl')->nullable();
                $table->string('adomain')->nullable();
                $table->tinyInteger('test')->default(0);
                $table->integer('weight')->default(0);
                $table->string('node')->nullable()->default("");
                $table->string('status')->default('active');
                $table->timestamps();

                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('campaigns');
    }
}
