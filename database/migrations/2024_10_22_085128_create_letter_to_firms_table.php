<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterToFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_to_firms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',2000);
            $table->string('full_address');
            $table->string('date');
            $table->string('date_of_birth');
            $table->string('firmsname');
            $table->string('firmsaddress');
            $table->string('firmsemail');
            $table->string('sponsor_name');
            $table->string('sponsor_relationship');
            $table->string('your');
            $table->string('your_date_of_birth');
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
        Schema::dropIfExists('letter_to_firms');
    }
}
