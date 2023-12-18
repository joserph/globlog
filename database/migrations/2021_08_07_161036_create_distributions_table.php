<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();

            $table->string('hawb')->nullable();
            $table->integer('pieces')->nullable();
            $table->integer('hb')->nullable();
            $table->integer('qb')->nullable();
            $table->integer('eb')->nullable();
            $table->double('fulls', 8, 3)->nullable();
            $table->integer('hb_r')->nullable();
            $table->integer('qb_r')->nullable();
            $table->integer('eb_r')->nullable();
            $table->integer('pieces_r')->nullable();
            $table->double('fulls_r', 8, 3)->nullable();
            $table->integer('missing')->nullable(); //faltante
            $table->integer('returns')->nullable(); // Devoluciones
            $table->string('observation')->nullable();

            $table->foreignId('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('id_farm')->references('id')->on('farms')->onDelete('cascade');
            $table->foreignId('id_flight')->references('id')->on('flights')->onDelete('cascade');
            $table->foreignId('variety_id')->references('id')->on('varieties')->onDelete('cascade');
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
        Schema::dropIfExists('distributions');
    }
}
