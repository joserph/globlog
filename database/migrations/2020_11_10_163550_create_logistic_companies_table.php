<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('ruc');
            $table->string('phone');
            $table->string('address');
            $table->string('state'); // Parroquia
            $table->string('city');
            $table->string('country');
            $table->string('active');
            $table->integer('update_user')->nullable();
            
            $table->foreignId('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('logistic_companies');
    }
}
