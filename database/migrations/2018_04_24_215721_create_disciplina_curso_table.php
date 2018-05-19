<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinaCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplina_curso', function (Blueprint $table) {
 
            $table->increments('id');
            $table->timestamps();
            $table->integer('disciplina_id');
            $table->integer('curso_id');

            $table->foreign('disciplina_id')->references('id')
            ->on('disciplinas')->onDelete('cascade');

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
        Schema::dropIfExists('disciplina_curso');
    }
}
