<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCclApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ccl_applications')) {
            Schema::create('ccl_applications', function (Blueprint $table) {
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
                $table->timestamps();
            });

        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccl_applications');
    }
}
