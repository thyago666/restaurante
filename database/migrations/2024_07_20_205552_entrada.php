<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entrada', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger('id_ingrediente');
            $table->integer('qtd');
            $table->float('valor_total');
            $table->timestamps();

            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrada');
    }
};
