<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hits')->default(0);
            $table->json("fields")->nullable();
            $table->string("title");
            $table->string("name");
            $table->string("type")->default("general");
            $table->string('description')->nullable();
            $table->string("uuid");
            $table->enum("status",['active','inactive'])->default('active');
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
        Schema::dropIfExists('enquiry_forms');
    }
}
