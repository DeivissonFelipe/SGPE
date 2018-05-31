<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

class AtendimentoTest extends TestCase{
    use DatabaseTransactions;
    
    public function test_route_atendimento_store(){
        $faker = Faker::create();
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);
        
        $dias = ['Segunda-Feira','Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira'];
        $atendimento = [
            'dia' => $faker->randomElement($dias),
            'inicio' => '13:00',
            'fim' => '15:30',
            'sala' => 'G111',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('POST', 'atendimentos', $atendimento)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/atendimentos');
        
            
        $atendimento_retrieved = \App\Atendimento::get()->first();
        $this->assertEquals('13:00', $atendimento_retrieved->inicio);
        $this->assertEquals('15:30', $atendimento_retrieved->fim);
        $this->assertEquals('G111', $atendimento_retrieved->sala);
        
        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }

    public function test_route_atendimento_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        $atendimento = factory(\App\Atendimento::class)->create([
            'dia' => 'Segunda-Feira',
            'inicio' => '13:00',
            'fim' => '15:30',
            'sala' => 'G111',
            'plano_id' => $plano->id
        ]);

        $atendimento_id = \App\Atendimento::get()->first()->id;

        $atendimento_edited = [
            'id' => $atendimento_id,
            'dia' => 'Terça-Feira',
            'inicio' => '17:00',
            'fim' => '18:30',
            'sala' => 'G222',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('PATCH', 'atendimentos/'.$atendimento_id, $atendimento_edited)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/atendimentos');

        $atendimento_retrieved = \App\Atendimento::find($atendimento_id);
        $this->assertEquals('Terça-Feira', $atendimento_retrieved->dia);
        $this->assertEquals('17:00', $atendimento_retrieved->inicio);
        $this->assertEquals('18:30', $atendimento_retrieved->fim);
        $this->assertEquals('G222', $atendimento_retrieved->sala);
    }

    public function test_route_atendimento_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        $atendimento = factory(\App\Atendimento::class)->create([
            'dia' => 'Segunda-Feira',
            'inicio' => '13:00',
            'fim' => '15:30',
            'sala' => 'G111',
            'plano_id' => $plano->id
        ]);

        $atendimento_id = \App\Atendimento::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'atendimentos/'.$atendimento_id, ['plano_id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/atendimentos');
            
        $this->assertDatabaseMissing('atendimentos', ['id' => $atendimento_id]);
    }
}
