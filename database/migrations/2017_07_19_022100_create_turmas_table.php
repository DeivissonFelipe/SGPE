<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
        
            $table->increments('id');
            $table->integer('disciplina_id')->unsigned();
            $table->integer('semestre_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->integer('tipo_turma')->unsigned();
            $table->integer('numero_turma')->nullable();
            $table->timestamps();

            $table->foreign('disciplina_id')->references('id')
            ->on('disciplinas')->onDelete('cascade');
            
            $table->foreign('semestre_id')->references('id')
            ->on('semestres')->onDelete('cascade');

            $table->foreign('curso_id')->references('id')
            ->on('cursos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
