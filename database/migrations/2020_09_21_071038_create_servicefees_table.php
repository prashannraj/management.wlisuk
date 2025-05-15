<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicefeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicefees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->string('name');
            $table->integer('iso_currency_id');
            $table->decimal('net',10,2);
            $table->decimal('vat',10,2);
            $table->decimal('total',10,2);
            $table->string('note');


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
        Schema::dropIfExists('servicefees');
    }
}
