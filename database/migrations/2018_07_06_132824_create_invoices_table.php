<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_id');
            $table->string('offer_id')->unique()->nullable();
            $table->timestamp('offer_date')->nullable();
            $table->integer('offer_amount');
            $table->string('invoice_id')->unique()->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('invoice_due')->nullable();
            $table->string('banker_transaction_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('paid')->default(0);
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('description')->default('');
            $table->string('transaction_id')->default('');
            $table->string('currency')->default('USD');
            $table->string('vat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}