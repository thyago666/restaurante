<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id(); // Cria a coluna `id` como bigint unsigned, auto_increment, e primary key
            $table->string('descricao', 30)->nullable();
            $table->string('tipo', 15)->nullable();
            $table->integer('situacao')->nullable(); // Remove o auto_increment e primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
