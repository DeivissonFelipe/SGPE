<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class HorarioTest extends TestCase{
    use DatabaseTransactions;

    public function test_route_horario_store(){
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

        $horario = [
            'dia' => 'Segunda-Feira',
            'inicio' => '13:30',
            'fim' => '15:00',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('POST', 'horarios', $horario)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/aula');
        

        $horario_retrieved = \App\Horario::get()->first();
        $this->assertEquals('Segunda-Feira', $horario_retrieved->dia);
        $this->assertEquals('13:30', $horario_retrieved->inicio);
        $this->assertEquals('15:00', $horario_retrieved->fim);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_horario_update(){
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

        $horario = factory(\App\Horario::class)->create([
            'dia' => 'Segunda-Feira',
            'inicio' => '13:30',
            'fim' => '15:00',
            'plano_id' => $plano->id
        ]);

        $horario_id = \App\Horario::get()->first()->id;

        $horario_edited = [
            'id' => $horario_id,
            'dia' => 'Terça-Feira',
            'inicio' => '15:30',
            'fim' => '17:00',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('PATCH', 'horarios/'.$horario_id, $horario_edited)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/aula');
        

        $horario_retrieved = \App\Horario::get()->first();
        $this->assertEquals('Terça-Feira', $horario_retrieved->dia);
        $this->assertEquals('15:30', $horario_retrieved->inicio);
        $this->assertEquals('17:00', $horario_retrieved->fim);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_horario_delete(){
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

        $horario = factory(\App\Horario::class)->create([
            'dia' => 'Segunda-Feira',
            'inicio' => '13:30',
            'fim' => '15:00',
            'plano_id' => $plano->id
        ]);

        $horario_id = \App\Horario::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'horarios/'.$horario_id, ['plano_id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/aula');
        
        $this->assertDatabaseMissing('horarios', ['id' => $horario_id]);
    }
}
