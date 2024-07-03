<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsIntoFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
    Schema::table('files', function (Blueprint $table) { 
        $table->string('filename', 60);
        $table->string('title', 60);
        $table->string('description')->nullable();
        $table->tinyInteger('type_id')->unsigned()->nullable();

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('files', function (Blueprint $table) {
        $table->dropColumn('filename');
        $table->dropColumn('title');
        $table->dropColumn('description');
        $table->dropColumn('type_id');

    });

    }
}
