<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_in_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('description_id')->references('id')->on('item_for_invoices');
            $table->foreignId('invoice_id')->references('id')->on('invoices');
            $table->string('pieces');
            $table->string('quantity');
            $table->string('rate');
            $table->string('amount');

            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('update_user')->references('id')->on('users');

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
        Schema::dropIfExists('item_in_invoices');
    }
}
