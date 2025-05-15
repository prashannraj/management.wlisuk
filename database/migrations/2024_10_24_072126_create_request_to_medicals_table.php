<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestToMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_to_medicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',2000);
            $table->string('practice_name');
            $table->string('practice_address');
            $table->string('date');
            $table->integer('enquiry_id');
            $table->integer('advisor_id');
            $table->integer('iso_country_id');
            $table->string('full_address');
            $table->string('paitent_name');
            $table->string('paitent_address');
            $table->string('date_of_birth');
            $table->string('sex');
            $table->string('language');
            $table->string('contact_by');
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
        Schema::dropIfExists('request_to_medicals');
    }
}
