<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressesToRawInquiries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_inquiries', function (Blueprint $table) {
            //
            $table->integer('country_id')->default(235);
            $table->string('address')->default('');
            $table->string('postal_code')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raw_inquiries', function (Blueprint $table) {
            //
            $table->dropColumn('country_id');
            $table->dropColumn('address');
            $table->dropColumn('postal_code');
        });
    }
}
