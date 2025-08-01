<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_activities')) {
            Schema::create('user_activities', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type');
                $table->unsignedBigInteger('parent_id')->nullable()->comment('Parent Activity ID');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('object_id');
                $table->string('object_type', 60);
                $table->text('data')->nullable();
                $table->timestamps();
    
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('parent_id')->references('id')->on('user_activities')->onDelete('cascade');
            });
        }
    }
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
}
