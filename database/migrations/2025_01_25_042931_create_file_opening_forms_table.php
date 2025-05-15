<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileOpeningFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_opening_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',8000);
            $table->string('client_name');
            $table->string('date_of_birth');
            $table->integer('iso_country_id');
            $table->string('matter');
            $table->string('date');
            $table->string('email');
            $table->string('current_address');
            $table->string('mobile');
            $table->string('authorised_name');
            $table->string('authorised_relation');
            $table->string('contact_no');
            $table->string('authorised_email');
            $table->string('authorised_address');
            $table->string('word');
            $table->integer('enquiry_id');
            $table->integer('advisor_id');
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
        Schema::dropIfExists('file_opening_forms');
    }
}
