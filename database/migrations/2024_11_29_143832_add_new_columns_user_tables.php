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
        Schema::table('users', function (Blueprint $table) {
            //Adicionar as Colunas de Tipo de empregado
            $table->enum('type_of_employee', ['bolsista', 'CLT', 'CLT mais bolsista', 'estagio', 'estagio mais bolsista', 'consultoria', 'outros'])->default('bolsista');

            // Adicionar a coluna de total de horas por semana
            $table->time('weekly_hours')->default('20:00')->comment('Total de horas por semana');

            // Adicionar a coluna de total de horas por semana
            $table->time('extra_hours')->default('00:00')->comment('Total de horas Extras');

            // Adicionar a coluna do path da image para o profile
            $table->string('profile_image_path')->nullable()->comment('Path da imagem do perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type-of-employee');

            // Remover a coluna de total de horas por semana
            $table->dropColumn('weekly_hours');

            // Remover a coluna de total de horas por semana
            $table->dropColumn('extra_hours');

            // Remover a coluna de path da image para o profile
            $table->dropColumn('profile_image_path');
        });
    }
};
