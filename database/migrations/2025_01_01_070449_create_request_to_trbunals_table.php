<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestToTrbunalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_to_trbunals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',2000);
            $table->string('reference_number');
            $table->string('appellant_name');
            $table->string('date');
            $table->string('date_of_birth');
            $table->string('current_address');
            $table->string('appeal_number');
            $table->string('sex');
            $table->string('contacted_by');
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
        Schema::dropIfExists('request_to_trbunals');
    }
}
