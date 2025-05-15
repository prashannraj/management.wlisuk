<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('basic_info_id');
            $table->string("name");
            $table->enum('status',['completed','pending','cancelled'])->default('pending');
            $table->string('description')->nullable();
            $table->string("unique_code")->nullable();
            $table->integer('applying_from');
            $table->integer('applying_to');
            $table->string('type')->default("immigration");
            $table->integer("application_detail_id")->nullable();
            $table->json('files')->nullable();
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
        Schema::dropIfExists('application_assessments');
    }
}
