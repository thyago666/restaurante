<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('descricao')->nullable();
            $table->string('descricaoSimples', 20)->nullable();
            $table->string('unidMedida', 10)->nullable();
            $table->float('valor', 8, 2)->nullable();
            $table->integer('qtd_porcao')->nullable();
            $table->string('tipo', 2)->nullable();
            $table->unsignedBigInteger('id_produto')->nullable();
            $table->integer('qtdEmb')->nullable();
            $table->string('bonificacao', 1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredientes');
    }
};
