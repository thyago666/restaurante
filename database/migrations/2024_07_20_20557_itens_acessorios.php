<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens_acessorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_acessorio');
            $table->unsignedBigInteger('id_produto');
            $table->integer('qtd');
            $table->timestamps();

            $table->foreign('id_acessorio')->references('id')->on('acessorios')->onDelete('cascade');
            $table->foreign('id_produto')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens_acessorios');
    }
};
