<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceAndTransactionColumnsToBankerSpendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banker_spend', function (Blueprint $table) {
            $table->string('invoice_id');
            $table->string('transaction_id')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('banker_spend', function (Blueprint $table) {
            $table->dropColumn('invoice_id');
            $table->dropColumn('transaction_id');
        });
    }
}
