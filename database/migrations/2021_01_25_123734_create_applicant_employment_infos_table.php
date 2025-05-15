<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantEmploymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_employment_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("company_name");
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->string("position");
            $table->string("sponsor_name")->default(null);
            $table->integer("currency_id");
            $table->decimal("currency_rate",10,5);
            $table->string("calculation_type");
            $table->string("salary_requirement");
            $table->integer('application_assessment_id');
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
        Schema::dropIfExists('applicant_employment_infos');
    }
}
