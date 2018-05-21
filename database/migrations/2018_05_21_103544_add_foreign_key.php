<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disciplinas', function(Blueprint $table){
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });

        Schema::table('planos', function(Blueprint $table){
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
        }); 
    
        Schema::table('atendimentos', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        }); 

        Schema::table('exames', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        }); 

        Schema::table('planejamento_aulas', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        });

        Schema::table('planejamento_unidades', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        });
    
        Schema::table('horarios', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        });
        
        Schema::table('trocas', function(Blueprint $table){
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
        });

        Schema::table('feriados', function(Blueprint $table){
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
        });
    
        Schema::table('user_role', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    
        Schema::table('turmas', function(Blueprint $table){
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
        });

        Schema::table('user_turma', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
        });

        Schema::table('disciplina_curso', function(Blueprint $table){
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
        });

        Schema::table('pendencias', function(Blueprint $table){
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        });            

    }
}
