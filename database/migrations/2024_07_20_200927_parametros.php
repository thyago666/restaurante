<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('titulo', 10);
            $table->longText('descricao');
            $table->string('opcao',3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parametros');
    }
};
