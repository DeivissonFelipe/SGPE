<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TurmaTest extends TestCase{
    use DatabaseTransactions;
    
    public function test_route_turma_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $response = $this->actingAs($user)->json('GET', 'turmas/')
                        ->assertStatus(200)
                        ->assertViewIs('turmas.index')
                        ->assertViewHas('turmas');     
    }
    public function test_route_turma_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $response = $this->actingAs($user)->json('GET', 'turmas/create')
                        ->assertStatus(200)
                        ->assertViewIs('turmas.create')
                        ->assertViewHas(['users', 'semestres', 'disciplinas', 'cursos']);
    }
    public function test_route_turma_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
    	$curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);
        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $turma = [
            'user_id' => [$user->id],
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id
        ];

        $response = $this->actingAs($user)->json('POST', 'turmas', $turma)
                        ->assertStatus(302)
                        ->assertRedirect('/turmas');

        $turma_retrieved = \App\Turma::get()->first();
        $this->assertEquals($disciplina->id, $turma_retrieved->disciplina_id);
        $this->assertEquals($curso->id, $turma_retrieved->curso_id);
        $this->assertEquals($semestre->id, $turma_retrieved->semestre_id);
    }
    public function test_route_turma_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
    	$curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);
        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $turma = factory(\App\Turma::class)->create([
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id
        ]);
        $turma->users()->attach($user->id);

        $response = $this->actingAs($user)->json('GET', 'turmas/'.$turma->id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('turmas.edit')
                        ->assertViewHas('turma');
    }
    public function test_route_turma_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
    	$curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);
        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $turma = factory(\App\Turma::class)->create([
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id
        ]);
        $turma->users()->attach($user->id);

        $disciplina2 = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI488',
            'nome' => 'ALGORITMOS E ESTRUTURA DE DADOS I',
            'name' => 'ALGORITHMS AND DATA STRUCTURE I',
            'departamento_id' => $departamento->id
        ]);
        $disciplina2->cursos()->attach($curso);

        $turma_edited = [
            'tipo_turma' => '1',
            'disciplina_id' => $disciplina2->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id
        ];

        $response = $this->actingAs($user)->json('PATCH', 'turmas/'. $turma->id, $turma_edited)
                        ->assertStatus(302)
                        ->assertRedirect('/turmas');
        
        $turma_retrieved = \App\Turma::get()->first();
        $this->assertEquals('1', $turma_retrieved->tipo_turma);
        $this->assertEquals($disciplina2->id, $turma_retrieved->disciplina_id);
    }
    public function test_route_turma_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
    	$curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);
        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $turma = factory(\App\Turma::class)->create([
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id
        ]);
        $turma->users()->attach($user->id);

        $plano = factory(\App\Plano::class)->create([
            'turma_id'=> $turma->id
        ]);
        
        $response = $this->actingAs($user)->json('DELETE', 'turmas/'.$turma->id, ['id' => $turma->id])
            ->assertStatus(302)
            ->assertRedirect('/turmas');
            
        $this->assertDatabaseMissing('turmas', ['id' => $turma->id]);
        
    }
}

