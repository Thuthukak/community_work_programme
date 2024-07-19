<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable()->after('id'); // Adding the company_id column
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null'); // Adding the foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']); // Dropping the foreign key constraint
            $table->dropColumn('company_id'); // Dropping the company_id column
        });
    }
}
