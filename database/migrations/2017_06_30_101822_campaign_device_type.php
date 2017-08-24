<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignDeviceType extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'campaign_device_type',
            function (Blueprint $table) {

                $table->increments('id');
                $table->unsignedInteger('campaign_id');
                $table->unsignedInteger('device_type_id');
                $table->timestamps();

                $table->foreign('campaign_id')
                    ->references('id')
                    ->on('campaigns')
                    ->onDelete('cascade');;

                $table->foreign('device_type_id')
                    ->references('id')
                    ->on('device_types')->onDelete('cascade');
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

        Schema::dropIfExists('campaign_device_type');
    }
}
