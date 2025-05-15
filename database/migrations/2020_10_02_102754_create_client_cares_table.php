<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_cares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('discussion_details',2000);
            $table->string('full_address');
            $table->string('added_names_input',2000);
            $table->string('additional_notes',2000);
            $table->string('date');
            $table->integer('advisor_id');
            $table->integer('servicefee_id');
            $table->integer('bank_id');
            $table->integer('agreed_fee_currency_id');
            $table->decimal('agreed_fee',14,2);
            $table->integer('enquiry_id');
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
        Schema::dropIfExists('client_cares');
    }
}
