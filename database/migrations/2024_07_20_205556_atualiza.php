<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        schema::create('atualiza', function (Blueprint $table) {
            $table->id(); // Cria a coluna `id` como bigint unsigned, auto_increment, e primary key
            $table->unsignedBigInteger('id_produto'); // Coluna para chave estrangeira
            $table->double('valor_anterior', 8, 2)->nullable(); // Corrigido para double(8, 2)
            $table->double('valor_atual', 8, 2)->nullable(); // Corrigido para double(8, 2)
            $table->string('descricao', 255)->nullable();
            $table->timestamps();

            // Adiciona a chave estrangeira
            $table->foreign('id_produto')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('atualiza');
    }

};

