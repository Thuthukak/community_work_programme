<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProjectJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ProjectJobs', function (Blueprint $table) {
            $table->renameColumn('worker_id', 'person_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ProjectJobs', function (Blueprint $table) {
            $table->renameColumn('person_id', 'worker_id');
        });
    }
}
