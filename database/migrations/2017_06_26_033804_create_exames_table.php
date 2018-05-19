<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->integer('peso')->nullable();
            $table->date('data')->nullable();
            $table->string('conteudo');
            $table->integer('plano_id')->unsigned();
            $table->timestamps();

            $table->foreign('plano_id')->references('id')
            ->on('planos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exames');
    }
}
