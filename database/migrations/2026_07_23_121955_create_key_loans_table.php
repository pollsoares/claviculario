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
        Schema::create('key_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('key_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Profissional que retirou
            $table->timestamp('borrowed_at'); // Data/hora da retirada
            $table->timestamp('returned_at')->nullable(); // Preenchido só na devolução
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_loans');
    }
};
