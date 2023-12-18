<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketerCoordination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coordinations', function($table)
		{
            $table->integer('id_marketer')->nullable();
            $table->string('observation')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coordinations', function($table)
		{
		    $table->dropColumn('id_marketer');
            $table->dropColumn('observation');
		});
    }
}
