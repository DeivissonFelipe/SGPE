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

            $table->unsignedInteger('tipo');
            $table->unsignedInteger('turma_id');
            
            $table->text('objetivo')->nullable();
            $table->text('metodologia')->nullable();
            $table->text('avaliacao')->nullable();
            $table->text('observacoes')->nullable();
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
        Schema::dropIfExists('planos');
    }
}