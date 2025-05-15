<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoverLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cover_letters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('application_id')->default(null);
            $table->integer('application_assessment_id');
            $table->string('to_address');
            $table->date("date");
            $table->string("re");
            $table->boolean("include_financial_assessment")->default(false);
            $table->longText("text")->default('');
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
        Schema::dropIfExists('cover_letters');
    }
}
