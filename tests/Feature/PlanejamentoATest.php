<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class PlanejamentoATest extends TestCase{
    use DatabaseTransactions;

    public function test_route_planejamentoA_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'inicio' => Carbon::create('2018', '03', '12'),
            'fim' => Carbon::create('2018', '07', '21'),
        ]);
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }

        $planejamento = [
            'aula' => '1',
            'tipo' => 'T',
            'data' => '2018-03-12',
            'conteudo' => 'Conteudo da aula 1',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('POST', 'planejamentoAulas', $planejamento)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $plan_retrieved = \App\PlanejamentoAula::get()->first();
        $this->assertEquals('1', $plan_retrieved->aula);
        $this->assertEquals('T', $plan_retrieved->tipo);
        $this->assertEquals('12-03-2018', $plan_retrieved->data);
        $this->assertEquals('Conteudo da aula 1', $plan_retrieved->conteudo);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_planejamentoA_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'inicio' => Carbon::create('2018', '03', '12'),
            'fim' => Carbon::create('2018', '07', '21'),
        ]);
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }

        $planejamento = factory(\App\PlanejamentoAula::class)->create([
            'aula' => '1',
            'tipo' => 'T',
            'data' => '2018-03-12',
            'conteudo' => 'Conteudo da aula 1',
            'plano_id' => $plano->id
        ]);
        
        $planejamento_id = \App\PlanejamentoAula::get()->first()->id;

        $planejamento_edited = [
            'aula' => '2',
            'tipo' => 'P',
            'data' => '2018-03-14',
            'conteudo' => 'Conteudo da aula 2',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('PATCH', 'planejamentoAulas/'.$planejamento_id, $planejamento_edited)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $plan_retrieved = \App\PlanejamentoAula::get()->first();
        $this->assertEquals('2', $plan_retrieved->aula);
        $this->assertEquals('P', $plan_retrieved->tipo);
        $this->assertEquals('14-03-2018', $plan_retrieved->data);
        $this->assertEquals('Conteudo da aula 2', $plan_retrieved->conteudo);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);

    }
    public function test_route_planejamentoA_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'inicio' => Carbon::create('2018', '03', '12'),
            'fim' => Carbon::create('2018', '07', '21'),
        ]);
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        $planejamento = factory(\App\PlanejamentoAula::class)->create([
            'aula' => '1',
            'tipo' => 'T',
            'data' => '2018-03-12',
            'conteudo' => 'Conteudo da aula 1',
            'plano_id' => $plano->id
        ]);
        
        $planejamento_id = \App\PlanejamentoAula::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'planejamentoAulas/'.$planejamento_id, ['plano_id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $this->assertDatabaseMissing('planejamento_aulas', ['id' => $planejamento_id]);
    }
}
