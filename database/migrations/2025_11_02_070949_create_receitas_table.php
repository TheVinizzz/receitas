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
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuarios');
            $table->unsignedBigInteger('id_categorias')->nullable();
            $table->string('nome', 45)->nullable();
            $table->unsignedInteger('tempo_preparo_minutos')->nullable();
            $table->unsignedInteger('porcoes')->nullable();
            $table->text('modo_preparo');
            $table->text('ingredientes')->nullable();
            $table->timestamp('criado_em');
            $table->timestamp('alterado_em');
            
            $table->foreign('id_usuarios')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_categorias')->references('id')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            
            $table->index('id_usuarios');
            $table->index('id_categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receitas');
    }
};
