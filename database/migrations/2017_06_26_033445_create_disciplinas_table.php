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
            $table->string('chsemestral')->nullable();
            $table->string('chsemanalp')->nullable();
            $table->string('chsemanalt')->nullable();
            $table->integer('departamento_id')->unsigned();
            $table->timestamps();

            $table->foreign('departamento_id')->references('id')
            ->on('departamentos')->onDelete('cascade');
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
