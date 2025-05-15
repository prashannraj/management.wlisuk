<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content',8000);
            $table->string('reference_number');
            $table->string('appellant_name');
            $table->string('date');
            $table->string('date_of_birth');
            $table->string('current_address');
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
        Schema::dropIfExists('subject_accesses');
    }
}
