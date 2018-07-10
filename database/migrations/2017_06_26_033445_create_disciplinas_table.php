<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('codigo', 10)->unique();
            $table->string('nome', 100);
            $table->string('name', 100);

            $table->unsignedInteger('chsemestral');
            $table->unsignedInteger('chsemanalp');
            $table->unsignedInteger('chsemanalt');
            $table->unsignedInteger('departamento_id');
            
            $table->text('ementa')->nullable();
            $table->text('conteudo')->nullable();
            $table->text('bibliografiab')->nullable();
            $table->text('bibliografiac')->nullable();
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
        Schema::dropIfExists('disciplinas');
    }
}
