<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientConfimMasterInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_invoice_items', function($table)
		{
            $table->foreignId('client_confim_id')->references('id')->on('clients')->onDelete('cascade')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_invoice_items', function($table)
		{
		    $table->dropColumn('client_confim_id');
		});
    }
}
