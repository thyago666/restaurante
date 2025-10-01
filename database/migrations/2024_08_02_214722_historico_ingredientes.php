<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historico_ingredientes', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->integer('id_ingrediente')->unsigned();
        $table->double('valor',8.2);
        $table->timestamps();
        $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
       
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
