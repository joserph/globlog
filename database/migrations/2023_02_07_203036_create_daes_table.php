<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daes', function (Blueprint $table) {
            $table->id();

            $table->string('destination_country');
            $table->string('num_dae')->unique();
            $table->foreignId('id_farm')->references('id')->on('farms');
            $table->date('date');
            $table->date('arrival_date');

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
        Schema::dropIfExists('daes');
    }
}
