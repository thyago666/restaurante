<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('custo_fixo', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('descricao', 30);
            $table->double('valor');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('custo_fixo');
    }
};
