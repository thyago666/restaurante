<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ifood', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('descricao', 20);
            $table->float('valor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ifood');
    }
};
