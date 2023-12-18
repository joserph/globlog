<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickUpOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up_order_items', function (Blueprint $table) {
            $table->id();

            $table->string('awb')->nullable();
            $table->string('description')->nullable();
            $table->string('pieces')->nullable();
            $table->string('pallets')->nullable();

            $table->foreignId('id_pickup')->references('id')->on('pick_up_orders');
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
        Schema::dropIfExists('pick_up_order_items');
    }
}
