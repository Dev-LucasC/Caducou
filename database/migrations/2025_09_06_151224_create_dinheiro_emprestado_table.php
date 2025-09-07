<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dinheiro_emprestado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome_cliente');
            $table->string('email_cliente')->nullable();
            $table->string('telefone_cliente')->nullable();
            $table->decimal('valor', 10, 2);
            $table->string('descricao');
            $table->date('data');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('dinheiro_emprestado');
    }
};
