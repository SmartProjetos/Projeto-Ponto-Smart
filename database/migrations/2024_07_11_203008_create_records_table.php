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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('date')->nullable();
            $table->time('entry_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('total_hours')->nullable();
            $table->time('project1_hours')->nullable();
            $table->string('project1_name')->nullable();
            $table->time('project2_hours')->nullable();
            $table->string('project2_name')->nullable();
            $table->time('project3_hours')->nullable();
            $table->string('project3_name')->nullable();
            $table->time('project4_hours')->nullable();
            $table->string('project4_name')->nullable();
            $table->time('project5_hours')->nullable();
            $table->string('project5_name')->nullable();
            $table->time('project6_hours')->nullable();
            $table->string('project6_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
