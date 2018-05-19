<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('aprovacao')->nullable();
            $table->string('status');
            $table->integer('tipo')->nullable();
            $table->integer('turma_id')->unsigned();
            
            $table->text('ementa')->nullable();
            $table->text('conteudo')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('metodologia')->nullable();
            $table->text('avaliacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->text('bibliografiab')->nullable();
            $table->text('bibliografiac')->nullable();
            $table->timestamps();

            $table->foreign('turma_id')->references('id')
            ->on('turmas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planos');
    }
}