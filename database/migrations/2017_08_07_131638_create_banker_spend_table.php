<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankerSpendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banker_spend', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('spendable_type');
            $table->unsignedInteger('spendable_id');
            $table->bigInteger('debit');
            $table->bigInteger('credit');
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
        Schema::drop('banker_spend');
    }
}
