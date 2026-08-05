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
        Schema::create('controladores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->char('cpf', 11)->unique(); // Ex: "CPF"
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('controladores_password_reset_tokens', function (Blueprint $table) {
            $table->char('cpf', 11)->unique()->primary(); // Ex: "CPF"
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('controladores_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('controlador_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('controlador_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controladores');
        Schema::dropIfExists('controladores_password_reset_tokens');
        Schema::dropIfExists('controladores_sessions');
    }
};

