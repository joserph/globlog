<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQaFloorToLoadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->integer('id_qa')->references('id')->on('q_a_companies')->nullable();
            $table->enum('floor', ['si', 'no'])->nullable();
            $table->string('num_pallets')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->dropColumn('id_qa');
            $table->dropColumn('floor');
            $table->dropColumn('num_pallets');
        });
    }
}
