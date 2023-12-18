<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_headers', function (Blueprint $table) {
            $table->id();

            $table->integer('id_company')->nullable();
            //$table->integer('id_load')->unsigned()->nullable();
            $table->integer('id_logistics_company')->nullable();
            $table->string('bl')->nullable();
            $table->string('carrier')->nullable();
            $table->string('invoice')->nullable();
            $table->date('date');
            $table->double('total_bunches', 8, 2)->nullable();
            $table->double('total_fulls', 8, 3)->nullable();
            $table->double('total_pieces', 8, 2)->nullable();
            $table->double('total_stems', 8, 2)->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->integer('update_user')->nullable();
            
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_load')->references('id')->on('loads')->onDelete('cascade');

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
        Schema::dropIfExists('invoice_headers');
    }
}
