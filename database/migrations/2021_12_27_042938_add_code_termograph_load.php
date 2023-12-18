<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeTermographLoad extends Migration
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
            $table->string('code_deep', 50)->nullable();
            $table->string('brand_deep', 150)->nullable();
            $table->string('code_door', 50)->nullable();
            $table->string('brand_door', 150)->nullable();
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
		    $table->dropColumn('code_deep');
            $table->dropColumn('brand_deep');
            $table->dropColumn('code_door');
            $table->dropColumn('brand_door');
		});
    }
}
