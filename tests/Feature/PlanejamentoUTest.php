<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class PlanejamentoUTest extends TestCase{
    use DatabaseTransactions;

    public function test_route_planejamentoU_store(){
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

        $planejamento = [
            'unidade' => '1',
            'hora_aula' => '20', 
            'descricao' => 'Conteudo da unidade 1',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('POST', 'planejamentoUnidades', $planejamento)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $plan_retrieved = \App\PlanejamentoUnidade::get()->first();
        $this->assertEquals('1', $plan_retrieved->unidade);
        $this->assertEquals('20', $plan_retrieved->hora_aula);
        $this->assertEquals('Conteudo da unidade 1', $plan_retrieved->descricao);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_planejamentoU_update(){
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

        $planejamento = factory(\App\PlanejamentoUnidade::class)->create([
            'unidade' => '1',
            'hora_aula' => '20',
            'descricao' => 'Conteudo da unidade 1',
            'plano_id' => $plano->id
        ]);
        
        $planejamento_id = \App\PlanejamentoUnidade::get()->first()->id;

        $planejamento_edited = [
            'unidade' => '2',
            'hora_aula' => '30',
            'descricao' => 'Conteudo da unidade 2',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('PATCH', 'planejamentoUnidades/'.$planejamento_id, $planejamento_edited)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $plan_retrieved = \App\PlanejamentoUnidade::get()->first();
        $this->assertEquals('2', $plan_retrieved->unidade);
        $this->assertEquals('30', $plan_retrieved->hora_aula);
        $this->assertEquals('Conteudo da unidade 2', $plan_retrieved->descricao);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);

    }
    public function test_route_planejamentoU_delete(){
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

        $planejamento = factory(\App\PlanejamentoUnidade::class)->create([
            'unidade' => '1',
            'hora_aula' => '20',
            'descricao' => 'Conteudo da unidade 1',
            'plano_id' => $plano->id
        ]);
        
        $planejamento_id = \App\PlanejamentoUnidade::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'planejamentoUnidades/'.$planejamento_id, ['plano_id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/planejamentos');
        
        $this->assertDatabaseMissing('planejamento_unidades', ['id' => $planejamento_id]);
    }
}
