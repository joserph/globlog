<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();

            $table->integer('quantity');
            $table->string('type');
            $table->foreignId('id_variety')->references('id')->on('variety_flowers');
            $table->string('size');
            $table->string('bunch');
            $table->string('stem_bunch');
            $table->string('price_stem');
            $table->string('price');
            $table->string('total_stem');
            $table->foreignId('id_farm')->references('id')->on('farms');
            $table->string('invoice');
            $table->string('id_load_flight');
            $table->string('distribution');
            $table->string('buyer');
            $table->integer('cod_id_box');

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
        Schema::dropIfExists('shoppings');
    }
}
