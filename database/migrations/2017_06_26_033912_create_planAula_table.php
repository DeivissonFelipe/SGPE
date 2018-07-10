<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanAulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planejamento_aulas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aula');
            $table->string('tipo', 10);
            $table->date('data')->nullable();
            $table->string('conteudo');
            $table->unsignedInteger('plano_id');
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
        Schema::dropIfExists('planejamento_aulas');
    }
}
