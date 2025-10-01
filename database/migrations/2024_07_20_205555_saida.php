<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saida', function (Blueprint $table) {
            $table->id(); // Cria a coluna `id` como bigint unsigned, auto_increment, e primary key
            $table->string('descricao', 255)->notNullable();
            $table->double('valor', 8, 2)->notNullable();
            $table->date('vencimento')->notNullable();
            $table->string('status', 255)->notNullable();
            $table->unsignedBigInteger('id_ingrediente'); // Adiciona a coluna id_ingrediente
            $table->timestamps();

            // Adiciona a chave estrangeira
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saida');
    }
};
