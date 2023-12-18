<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketerDistribution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributions', function($table)
		{
            $table->integer('id_marketer')->nullable();
            $table->enum('duplicate', ['no', 'yes'])->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributions', function($table)
		{
		    $table->dropColumn('id_marketer');
            $table->dropColumn('duplicate');
		});
    }
}
