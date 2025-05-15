<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_cares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->integer('enquiry_id');
            $table->integer('advisor_id');
            $table->string("full_address");
            $table->longText("coverletter_content");
            $table->longText("additional_content")->nullable();
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
        Schema::dropIfExists('enquiry_cares');
    }
}
