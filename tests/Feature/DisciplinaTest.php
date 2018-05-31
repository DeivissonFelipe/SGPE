<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DisciplinaTest extends TestCase{
    use DatabaseTransactions;    

    public function test_route_disciplina_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $response = $this->actingAs($user)->json('GET', 'disciplinas/')
                        ->assertStatus(200)
                        ->assertViewIs('disciplinas.index')
                        ->assertViewHas('disciplinas');
    }
    public function test_route_disciplina_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $response = $this->actingAs($user)->json('GET', 'disciplinas/create')
                        ->assertStatus(200)
                        ->assertViewIs('disciplinas.create')
                        ->assertViewHas('departamentos');
    }
    public function test_route_disciplina_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);
        
        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);

        $disciplina = [
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id,
            'oferta' => [$curso->id]
        ];

        $response = $this->actingAs($user)->json('POST', 'disciplinas', $disciplina)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas');

        $disciplina_retrieved = \App\Disciplina::get()->first();
        $this->assertEquals('CSI030', $disciplina_retrieved->codigo);
        $this->assertEquals('PROGRAMACAO DE COMPUTADORES', $disciplina_retrieved->nome);
        $this->assertEquals('COMPUTER PROGRAMMING', $disciplina_retrieved->name);
        $this->assertEquals('60', $disciplina_retrieved->chsemestral);
        $this->assertEquals('2', $disciplina_retrieved->chsemanalp);
        $this->assertEquals('2', $disciplina_retrieved->chsemanalt);
        $this->assertEquals($departamento->id, $disciplina_retrieved->departamento_id);
    }
    public function test_route_disciplina_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);

        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);

        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $response = $this->actingAs($user)->json('GET', 'disciplinas/'.$disciplina->id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('disciplinas.edit')
                        ->assertViewHas(['departamentos', 'disciplina']);
    }
    public function test_route_disciplina_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);

        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);

        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);

        $disciplina_edited = [
            'codigo' => 'CSI488',
            'nome' => 'ALGORITMOS E ESTRUTURA DE DADOS I',
            'name' => 'ALGORITHMS AND DATA STRUCTURE I',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id,
            'oferta' => [$curso->id]
        ];

        $response = $this->actingAs($user)->json('PATCH', 'disciplinas/'.$disciplina->id, $disciplina_edited)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas');

        $disciplina_retrieved = \App\Disciplina::get()->first();
        $this->assertEquals('CSI488', $disciplina_retrieved->codigo);
        $this->assertEquals('ALGORITMOS E ESTRUTURA DE DADOS I', $disciplina_retrieved->nome);
        $this->assertEquals('ALGORITHMS AND DATA STRUCTURE I', $disciplina_retrieved->name);
        $this->assertEquals('60', $disciplina_retrieved->chsemestral);
        $this->assertEquals('2', $disciplina_retrieved->chsemanalp);
        $this->assertEquals('2', $disciplina_retrieved->chsemanalt);
        $this->assertEquals($departamento->id, $disciplina_retrieved->departamento_id);

    }
    public function test_route_disciplina_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $departamento = factory(\App\Departamento::class)->create([
            'sigla' => 'DECSI',
            'nome' => 'Departamento de Computação e Sistemas'
        ]);

        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);

        $disciplina = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI030',
            'nome' => 'PROGRAMACAO DE COMPUTADORES',
            'name' => 'COMPUTER PROGRAMMING',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id
        ]);
        $disciplina->cursos()->attach($curso);
        
        $response = $this->actingAs($user)->json('DELETE', 'disciplinas/'.$disciplina->id, ['id' => $disciplina->id])
            ->assertStatus(302)
            ->assertRedirect('/disciplinas');
            
        $this->assertDatabaseMissing('disciplinas', ['id' => $disciplina->id]);
    }
}
