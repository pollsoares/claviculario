<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as alterações na tabela.
     */
    public function up(): void
    {
        Schema::create('key_loans', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira para a tabela 'keys'
            $table->foreignId('key_id')
                  ->constrained('keys')
                  ->onDelete('cascade');

            // Chave estrangeira para a tabela 'users' (quem pega a chave emprestada)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Chave estrangeira para a tabela 'controladores' (quem registra o empréstimo)
            $table->foreignId('controlador_id')
                  ->constrained('controladores')
                  ->onDelete('cascade');

            // Datas do fluxo de empréstimo e devolução
            $table->timestamp('borrowed_at');             // Data/Hora da retirada
            $table->timestamp('returned_at')->nullable(); // Data/Hora da devolução (pode ser nula)

            $table->timestamps();
        });
    }

    /**
     * Reverte a migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_loans');
    }
};
