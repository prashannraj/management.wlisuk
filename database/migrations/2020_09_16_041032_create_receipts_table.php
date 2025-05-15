<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('basic_info_id')->nullable();

            $table->integer('iso_currency_id')->nullable();
            $table->decimal('amount_received',14,2)->default(0);
            $table->string('remarks')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
