<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantPayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_payslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date("date");
            $table->date("bank_date");
            $table->decimal('gross_pay',10,2);

            $table->decimal('net_pay',10,2);
            $table->enum("proof_sent",['Yes',"No"])->default("No");
            $table->string('note')->nullable();
            $table->integer('employment_info_id');
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
        Schema::dropIfExists('applicant_payslips');
    }
}
