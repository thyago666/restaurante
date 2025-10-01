<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entrada_acessorio', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger('id_acessorio');
            $table->integer('qtd');
            $table->double('valor_total', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrada_acessorio');
    }
};
