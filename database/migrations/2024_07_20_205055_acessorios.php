<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acessorios', function (Blueprint $table) {
            $table->id()->unsigned();
            // $table->string('nome')->nullable();
            $table->float('valor', 8, 2)->nullable();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acessorios');
    }
};
