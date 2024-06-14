<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::table('files', function (Blueprint $table) {
    //         $table->tinyInteger('type_id')->unsigned()->nullable();
    //         $table->string('filename', 60);
    //         $table->string('title', 60);
    //         $table->string('description')->nullable();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('type_id');
            $table->dropColumn('filename');
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
}
