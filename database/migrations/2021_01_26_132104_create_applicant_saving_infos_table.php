<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantSavingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_saving_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("bank_name");
            $table->string("account_name");
            $table->string("account_number");
            $table->date("start_date");
            $table->integer("currency_id");
            $table->decimal("currency_rate",10,5);
            $table->decimal("minimum_balance", 10, 2);
            $table->decimal("closing_balance", 10, 2);
            $table->date("closing_date");
            $table->integer('country_id');
            $table->integer("application_assessment_id");
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
        Schema::dropIfExists('applicant_saving_infos');
    }
}
