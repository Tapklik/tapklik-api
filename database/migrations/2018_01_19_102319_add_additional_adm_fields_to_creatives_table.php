<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalAdmFieldsToCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creatives', function (Blueprint $table) {

            $table->string('adm_js')->nullable();
            $table->string('adm_iframe')->nullable();
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
            $table->dropColumn('adm_js');
            $table->dropColumn('adm_iframe');
        });
    }
}
