<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP5060STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p5060_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("year");
            $table->string('document');
            $table->string("type");
            $table->string("note")->nullable();
            $table->integer("employee_id")->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p5060_s');
    }
}
