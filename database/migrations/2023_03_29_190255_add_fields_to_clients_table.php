<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('owner')->nullable();
            $table->string('sub_owner')->nullable();
            $table->string('sub_owner_phone')->nullable();
            $table->string('related_names')->nullable();
            $table->string('buyer')->nullable();
            $table->enum('type_load', ['AEREO', 'MARITIMO', 'AEREO/MARITIMO'])->nullable();
            $table->string('delivery')->nullable();
            $table->string('method_payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('owner');
            $table->dropColumn('sub_owner');
            $table->dropColumn('sub_owner_phone');
            $table->dropColumn('related_names');
            $table->dropColumn('buyer');
            $table->dropColumn('type_load');
            $table->dropColumn('delivery');
            $table->dropColumn('method_payment');
        });
    }
}
