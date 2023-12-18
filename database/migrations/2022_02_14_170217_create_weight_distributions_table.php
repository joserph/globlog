<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_distributions', function (Blueprint $table) {
            $table->id();

            $table->string('report_w');
            $table->string('large');
            $table->string('width');
            $table->string('high');
            $table->string('average');
            $table->string('observation');

            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('update_user')->references('id')->on('users');
            $table->foreignId('id_distribution')->references('id')->on('distributions')->onDelete('cascade');
            $table->foreignId('id_flight')->references('id')->on('flights')->onDelete('cascade');

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
        Schema::dropIfExists('weight_distributions');
    }
}
