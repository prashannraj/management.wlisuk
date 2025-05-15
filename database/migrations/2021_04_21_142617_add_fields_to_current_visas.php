<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCurrentVisas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_visas', function (Blueprint $table) {
            //
            $table->softDeletes();  //add this line
            $table->date("delete_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('current_visas', function (Blueprint $table) {
            //
            $table->dropSoftDeletes(); //add this line
            $table->dropColumn("delete_at");
        });
    }
}
