<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("f_name")->nullable();
            $table->string("title")->nullable();
            $table->string("m_name")->nullable();
            $table->string("l_name")->nullable();
            $table->string("country_iso_mobile")->nullable();
            $table->string("nationality")->nullable();
            $table->string('mobile')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->integer('form_id')->nullable();
            $table->boolean('active')->default(1);
            $table->longText("additional_details")->nullable();
            $table->json("extra_details")->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->string("unique_code")->nullable();
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
        Schema::dropIfExists('raw_inquiries');
    }
}
