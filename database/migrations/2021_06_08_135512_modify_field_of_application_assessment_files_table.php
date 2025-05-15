<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFieldOfApplicationAssessmentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('application_assessment_files', function (Blueprint $table) {
            
            $table->longText('description')->nullable()->change();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('application_assessment_files', function (Blueprint $table) {
            
            $table->string('description')->nullable()->change();
           
        });
    }
}
