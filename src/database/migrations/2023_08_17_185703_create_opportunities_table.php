<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('organization_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('roles');
            $table->integer('opportunity_categorie_id');
            $table->string('position');
            $table->string('address');
            $table->integer('featured');
            $table->string('type');
            $table->integer('status');
            $table->date('last_date');
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
