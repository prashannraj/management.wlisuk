<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestToFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_to_finances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',2000);
            $table->string('agency');
            $table->string('client_name');
            $table->string('date');
            $table->string('date_of_birth');
            $table->string('street_address');
            $table->string('post_code');
            $table->string('account');
            $table->string('previous_address');
            $table->string('sex');
            $table->string('contact_by');
            $table->string('language');
            $table->integer('iso_country_id');
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
        Schema::dropIfExists('request_to_finances');
    }
}
