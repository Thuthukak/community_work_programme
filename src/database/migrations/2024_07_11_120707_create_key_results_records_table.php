<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyResultsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_results_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('key_results_id')->unsigned();
            $table->foreign('key_results_id')->references('id')->on('key_results')->onDelete('cascade');
            $table->float('history_value');
            $table->tinyInteger('history_confidence');
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
        Schema::dropIfExists('key_results_records');
    }
}
