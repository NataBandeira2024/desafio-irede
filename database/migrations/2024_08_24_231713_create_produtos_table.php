<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);  // Nome com máximo de 50 caracteres
            $table->string('descricao', 200);  // Descrição com máximo de 200 caracteres
            $table->double('preco');  // Preço como double
            $table->date('data_validade');  // Data de validade
            $table->string('imagem');  // Nome da imagem
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');  // Relacionamento com categoria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
