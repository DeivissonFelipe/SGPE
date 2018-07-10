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
    public function test_route_info(){
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

        $response = $this->actingAs($user)->json('GET', 'disciplinas/'.$disciplina->id.'/info')
                        ->assertStatus(200)
                        ->assertViewIs('disciplinas.info')
                        ->assertViewHas('disciplina');
    }
    public function test_route_disciplina_conteudo_post(){
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

        $conteudo = ['conteudo' => "Campo de conteudo", 'disciplina_id' => $disciplina->id];
        $response = $this->actingAs($user)->json('POST', 'disciplinas/conteudo', $conteudo)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas/'.$disciplina->id.'/info#conteudo');

        $disciplina_retrieved = \App\Disciplina::find($disciplina->id);
        $this->assertEquals('Campo de conteudo', $disciplina_retrieved->conteudo);
        $response->assertSessionHas('disciplina', $disciplina_retrieved);       
    }
    public function test_route_disciplina_ementa_post(){
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

        $ementa = ['ementa' => "Campo de ementa", 'disciplina_id' => $disciplina->id];
        $response = $this->actingAs($user)->json('POST', 'disciplinas/ementa', $ementa)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas/'.$disciplina->id.'/info#ementa');

        $disciplina_retrieved = \App\Disciplina::find($disciplina->id);
        $this->assertEquals('Campo de ementa', $disciplina_retrieved->ementa);
        $response->assertSessionHas('disciplina', $disciplina_retrieved);
    }
    public function test_route_disciplina_bibliografiab_post(){
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

        $bibliografiab = ['bibliografiab' => "Campo de bibliografiab", 'disciplina_id' => $disciplina->id];
        $response = $this->actingAs($user)->json('POST', 'disciplinas/bibliografiab', $bibliografiab)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas/'.$disciplina->id.'/info#bibb');

        $disciplina_retrieved = \App\Disciplina::find($disciplina->id);
        $this->assertEquals('Campo de bibliografiab', $disciplina_retrieved->bibliografiab);
        $response->assertSessionHas('disciplina', $disciplina_retrieved);
    }
    public function test_route_disciplina_bibliografiac_post(){
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

        $bibliografiac = ['bibliografiac' => "Campo de bibliografiac", 'disciplina_id' => $disciplina->id];
        $response = $this->actingAs($user)->json('POST', 'disciplinas/bibliografiac', $bibliografiac)
                        ->assertStatus(302)
                        ->assertRedirect('/disciplinas/'.$disciplina->id.'/info#bibc');

        $disciplina_retrieved = \App\Disciplina::find($disciplina->id);
        $this->assertEquals('Campo de bibliografiac', $disciplina_retrieved->bibliografiac);
        $response->assertSessionHas('disciplina', $disciplina_retrieved);
    }
}
