<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingLoad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::table('loads', function($table)
        {
            $table->string('booking')->nullable();
            $table->integer('id_logistic_company')->nullable();
            $table->string('container_number')->nullable();
            $table->string('seal_bottle')->nullable();
            $table->string('seal_cable')->nullable();
            $table->string('seal_sticker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loads', function($table)
		{
		    $table->dropColumn('booking');
            $table->dropColumn('id_logistic_company');
            $table->dropColumn('container_number');
            $table->dropColumn('seal_bottle');
            $table->dropColumn('seal_cable');
            $table->dropColumn('seal_sticker');
		});
    }
}
