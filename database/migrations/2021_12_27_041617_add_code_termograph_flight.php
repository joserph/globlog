<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeTermographFlight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flights', function($table)
		{
            $table->string('code', 50)->nullable();
            $table->string('brand', 150)->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flights', function($table)
		{
		    $table->dropColumn('code');
            $table->dropColumn('brand');
		});
    }
}
