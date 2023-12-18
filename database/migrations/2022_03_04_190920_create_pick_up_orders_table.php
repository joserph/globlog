<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickUpOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up_orders', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->date('loading_date');
            $table->time('loading_hour');
            $table->string('carrier_company')->nullable();
            $table->string('driver_name')->nullable();
            $table->integer('carrier_num');
            $table->string('pick_up_location');
            $table->string('pick_up_address');
            $table->string('city_pu');
            $table->string('state_pu');
            $table->string('zip_code_pu');
            $table->string('country_pu');
            $table->string('consigned_to');
            $table->string('drop_off_address');
            $table->string('city_do');
            $table->string('state_do');
            $table->string('zip_code_do');
            $table->string('country_do');

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
        Schema::dropIfExists('pick_up_orders');
    }
}
