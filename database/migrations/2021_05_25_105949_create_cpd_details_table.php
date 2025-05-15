<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->longText('what');
            $table->longText('why');
            $table->string('complete_objective');
            $table->longText('apply_learning');
            $table->integer('cpd_id')->unsigned();
            $table->timestamps();
            $table->foreign('cpd_id')->references('id')->on('cpds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cpd_details');
    }
}
