<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationAssessmentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_assessment_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('application_assessment_id');
            $table->integer('assessment_section_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string("location");
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
        Schema::dropIfExists('application_assessment_files');
    }
}
