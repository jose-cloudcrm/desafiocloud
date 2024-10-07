<?php

use App\Enums\TipoDePagamento;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//OK
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            //Por convenção sempre deixar timestamp no final da migration, ultimas colunas a serem criadas na tabela
            $table->timestamps();
            //Bom uso do enum aqui, porem poderia salvar tambem como um inteiro ao inves de string
            $table->string('tipoDePagamento');
            $table->boolean('bloqueado')->nullable()->default(false);
            $table->decimal('valor_total', 10, 2);
            //Aqui voce poderia utilizar foreignId uma sintaxe mais curta para definir a foreign.
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
