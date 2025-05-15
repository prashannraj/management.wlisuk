<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpds', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('advisor_id')->unsigned()->nullable();
            $table->string('advisor_number')->nullable();
            $table->string('advisor_name');
            $table->string('organization');
            $table->string('organization_number')->nullable();
            $table->date('period_from');
            $table->date('period_to');
            $table->string('status');
            $table->timestamps();
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cpds');
    }
}
