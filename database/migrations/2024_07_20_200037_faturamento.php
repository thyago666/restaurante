<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('faturamento', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->double('valor');
            $table->double('markup');
            $table->double('lucro');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faturamento');
    }
};
