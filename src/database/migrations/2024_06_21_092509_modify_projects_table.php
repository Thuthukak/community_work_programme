<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
        public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
          
            // Rename the column
            $table->renameColumn('customer_id', 'organization_id');

                    });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
        
            // Rename the column back to customer_id
            $table->renameColumn('organization_id', 'customer_id');

                    });
    }
}
