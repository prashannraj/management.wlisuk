<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('advisor_id');
            $table->date("date");
            $table->string("type")->default('attendance');
            $table->string('mode')->nullable();
            $table->string('file')->nullable();
            $table->integer('basic_info_id');
            $table->longText("details");
            $table->integer("hours")->default(0);
            $table->integer("minutes")->default(0);
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
        Schema::dropIfExists('attendance_notes');
    }
}
