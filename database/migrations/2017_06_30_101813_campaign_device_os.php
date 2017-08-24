<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignDeviceOs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(
            'campaign_device_os',
            function (Blueprint $table) {

                $table->increments('id');
                $table->unsignedInteger('campaign_id');
                $table->unsignedInteger('device_os_id');
                $table->timestamps();

                $table->foreign('campaign_id')->references('id')->on('campaigns');
                $table->foreign('device_os_id')->references('id')->on('device_os')->onDelete('cascade');;
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

        Schema::dropIfExists('campaign_device_os');
    }
}
