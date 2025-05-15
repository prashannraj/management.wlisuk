<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaExpiryEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('visa_expiry_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visa_id');
            $table->bigInteger('communication_log_id')->unsigned()->nullable();
            $table->foreign('visa_id')->references("id")->on('current_visas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('communication_log_id')->references("id")->on('communication_logs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('visa_expiry_emails');
    }
}
