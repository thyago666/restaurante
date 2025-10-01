<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('custo_variavel', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('descricao', 30);
            $table->double('valor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custo_variavel');
    }
};
