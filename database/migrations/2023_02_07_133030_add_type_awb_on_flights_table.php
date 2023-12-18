<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAwbOnFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->enum('type_awb', ['own', 'external'])->nullable();
            $table->enum('status', ['open', 'closed'])->default('closed')->nullable();
            $table->string('origin_city')->nullable();
            $table->string('origin_country')->nullable();
            $table->string('destination_city')->nullable();
            $table->string('destination_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('type_awb');
            $table->dropColumn('status');
            $table->dropColumn('origin_city');
            $table->dropColumn('origin_country');
            $table->dropColumn('destination_city');
            $table->dropColumn('destination_country');
        });
    }
}
