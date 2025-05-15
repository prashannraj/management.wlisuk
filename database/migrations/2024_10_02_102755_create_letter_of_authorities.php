<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfAuthorities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_authorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_name');
            $table->string('parent_address');
            $table->string('content',2000);
            $table->string('full_address');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('email');
            $table->date('date');
            $table->integer('enquiry_id');
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
        Schema::dropIfExists('letter_of_authorities');
    }
}
