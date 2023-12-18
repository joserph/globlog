<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQACompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_a_companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('owner');
            $table->string('address');
            $table->string('phone');
            $table->string('state'); // Parroquia
            $table->string('city');
            $table->string('country');
            $table->string('email');

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
        Schema::dropIfExists('q_a_companies');
    }
}
