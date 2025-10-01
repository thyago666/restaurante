<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->id(); // Cria a coluna `id` como bigint unsigned, auto_increment, e primary key
            $table->unsignedBigInteger('id_ingrediente')->notNullable(); // Apenas define como integer, sem auto_increment
            $table->unsignedBigInteger('id_produto')->notNullable();
            $table->integer('qtd')->notNullable();
            $table->integer('qtdOleoFritadeira')->notNullable();
            $table->integer('qtdPorcaoFritadeira')->notNullable();
            $table->timestamps();

            // Adiciona as chaves estrangeiras
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
            $table->foreign('id_produto')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens');
    }
};
