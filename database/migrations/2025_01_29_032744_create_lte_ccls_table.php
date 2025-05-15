<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLteCclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lte_ccls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('enquiry_id')->unsigned();
                $table->text('discussion_details');
                $table->string('full_address');
                $table->string('added_names_input', 2000);
                $table->string('additional_notes', 5000);
                $table->string('date');
                $table->integer('advisor_id');
                $table->integer('servicefee_id');
                $table->integer('bank_id');
                $table->integer('agreed_fee_currency_id');
                $table->decimal('agreed_fee', 14, 2);
                $table->string('discussion_date');
                $table->string('visa_application_submitted');
                $table->string('visa_type');
                $table->string('tribunal_fee');
                $table->string('vat');
                $table->string('travel_fee');
                $table->string('reappear_fee');
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
        Schema::dropIfExists('lte_ccls');
    }
}
