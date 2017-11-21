<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('company');
            $table->string('billing_address');
            $table->string('billing_email');
            $table->string('billing_country');
            $table->string('billing_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('company');
            $table->dropColumn('billing_address');
            $table->dropColumn('billing_email');
            $table->dropColumn('billing_country');
            $table->dropColumn('billing_city');
        });
    }
}
