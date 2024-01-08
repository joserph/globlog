<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->foreignId('client_id')->references('id')->on('clients');
            $table->string('num_invoice');
            $table->integer('count')->increments();
            $table->integer('load_id')->nullable();
            $table->integer('flight_id')->nullable();
            $table->date('date');
            $table->string('terms');
            $table->string('type');
            $table->string('load_type');
            // totales
            $table->string('total_pieces')->nullable();
            $table->string('total_quantity')->nullable();
            $table->string('total_amount')->nullable();

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
        Schema::dropIfExists('invoices');
    }
}
