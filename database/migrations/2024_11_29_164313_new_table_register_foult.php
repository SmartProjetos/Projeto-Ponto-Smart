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
        //Adiocionar tabela para ser o resgistro de falta
        Schema::create('faltas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date')->nullable();
            $table->enum('all_day', ['nao', 'sim'])->default('sim');
            $table->time('total_hours')->nullable();
            $table->text('observation')->nullable();
            $table->string('arquive')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faltas');
    }
};
