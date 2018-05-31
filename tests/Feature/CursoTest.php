<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CursoTest extends TestCase{
    use DatabaseTransactions;

    public function test_route_curso_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $cursos = factory(\App\Curso::class, 4)->create();

        $response = $this->actingAs($user)->json('GET', 'cursos/')
                        ->assertStatus(200)
                        ->assertViewIs('cursos.index')
                        ->assertViewHas('cursos');
    }
    public function test_route_curso_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $response = $this->actingAs($user)->json('GET', 'cursos/create')
                        ->assertStatus(200)
                        ->assertViewIs('cursos.create');
    }
    public function test_route_curso_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $curso = [
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ];
        $response = $this->actingAs($user)->json('POST', 'cursos', $curso)
                        ->assertStatus(302)
                        ->assertRedirect('/cursos');

        $curso_retrieved = \App\Curso::get()->first();
        $this->assertEquals('Sistemas de Informação', $curso_retrieved->nome);
        $this->assertEquals('SI', $curso_retrieved->sigla);
    }
    public function test_route_curso_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $curso_id = \App\Curso::get()->first()->id;
        $response = $this->actingAs($user)->json('GET', 'cursos/'.$curso_id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('cursos.edit')
                        ->assertViewHas('curso');
    }
    public function test_route_curso_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Sistemas de Informação',
            'sigla' => 'SI'
        ]);
        $curso_id = \App\Curso::get()->first()->id;

        $curso_edited = [
            'nome' => 'Engenharia de Computação',
            'sigla' => 'EC'
        ];
        $response = $this->actingAs($user)->json('PATCH', 'cursos/'. $curso_id, $curso_edited)
                        ->assertStatus(302)
                        ->assertRedirect('/cursos');
        
        $curso_retrieved = \App\Curso::get()->first();
        $this->assertEquals('Engenharia de Computação', $curso_retrieved->nome);
        $this->assertEquals('EC', $curso_retrieved->sigla);
    }
    public function test_route_curso_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $curso = factory(\App\Curso::class)->create([
            'nome' => 'Engenharia de Produção',
            'sigla' => 'EP'
        ]);
        $curso_id = \App\Curso::get()->first()->id;
        
        $response = $this->actingAs($user)->json('DELETE', 'cursos/'.$curso_id, ['id' => $curso_id])
            ->assertStatus(302)
            ->assertRedirect('/cursos');
            
        $this->assertDatabaseMissing('cursos', ['id' => $curso_id]);
    }
}
