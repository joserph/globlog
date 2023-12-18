<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_invoice_items', function (Blueprint $table) {
            $table->id();

            $table->string('hawb')->nullable();
            $table->integer('pieces')->nullable();
            $table->integer('hb')->nullable();
            $table->integer('qb')->nullable();
            $table->integer('eb')->nullable();
            $table->integer('stems')->nullable();
            $table->double('price')->nullable();
            $table->integer('bunches')->nullable();
            $table->double('fulls', 8, 3)->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->double('stems_p_bunches', 8, 2)->nullable();
            $table->integer('update_user')->nullable();
            $table->string('fa_cl_de')->nullable();

            $table->foreignId('id_invoiceh')->references('id')->on('invoice_headers')->onDelete('cascade');
            $table->foreignId('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('id_farm')->references('id')->on('farms')->onDelete('cascade');
            $table->foreignId('variety_id')->references('id')->on('varieties')->onDelete('cascade');
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
        Schema::dropIfExists('master_invoice_items');
    }
}
