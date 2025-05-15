<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("employee_id")->unsigned();
            $table->string("job_title");
            $table->date("start_date");
            $table->string("type");
            $table->string("working_hours");
            $table->string("working_days");
            $table->string("working_time");
            $table->string("salary");
            $table->string("salary_arrangement");
            $table->string("ni_number");
            $table->date("end_date")->nullable();
            $table->string("place_of_work");
            $table->string("region");
            $table->string("supervisor");
            $table->string("supervisor_email");
            $table->string("supervisor_tel");
            $table->string("probation_period");
            $table->date("probation_end_date");
            $table->integer("created_by")->unsigned();
            $table->integer("updated_by")->unsigned();
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
        Schema::dropIfExists('employment_infos');
    }
}
