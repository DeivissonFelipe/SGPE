<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia', 20);
            $table->string('inicio', 45);
            $table->string('fim', 45);
            $table->string('sala', 20);
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
        Schema::dropIfExists('atendimentos');
    }
}
