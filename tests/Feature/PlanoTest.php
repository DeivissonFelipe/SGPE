<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_route_plano_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));        

        $plano = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->json('GET', 'planos/')
                            ->assertStatus(200)
                            ->assertViewIs('planos.index')
                            ->assertViewHas('planos');
    }
    public function test_route_plano_show(){
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
        $this->assertDatabaseHas('planos', ['id' => $plano->id]);

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id)
                            ->assertStatus(200)
                            ->assertViewIs('planos.show')
                            ->assertViewHas('plano');
    }
    public function test_route_plano_edit(){
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
        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/edit')
                            ->assertStatus(200)
                            ->assertViewIs('planos.edit')
                            ->assertViewHas('plano')
                            ->assertViewHas('users')
                            ->assertViewHas('disciplinas')
                            ->assertViewHas('semestres')
                            ->assertViewHas('turma')
                            ->assertViewHas('h_array');
        
        $plano_retrieved = $response->original->getData()['plano'];
        $this->assertInstanceOf('App\Plano', $plano_retrieved);
        $this->assertEquals($plano_retrieved->id, $plano->id);
    }
    public function test_route_plano_planejamentos(){
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

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/planejamentos')
                            ->assertStatus(200)
                            ->assertViewIs('planos.partials-edit.planejamento')
                            ->assertViewHas(['plano','semestre','diasNaoLetivos']);
    }
    public function test_route_plano_avaliacao_get(){
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

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/avaliacoes')
                            ->assertStatus(200)
                            ->assertViewIs('planos.partials-edit.avaliacao')
                            ->assertViewHas('plano');
    }
    public function test_route_plano_metodologia_get(){
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

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/metodologias')
                            ->assertStatus(200)
                            ->assertViewIs('planos.partials-edit.metodologia')
                            ->assertViewHas('plano');
    }
    public function test_route_plano_objetivo_get(){
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

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/objetivos')
                            ->assertStatus(200)
                            ->assertViewIs('planos.partials-edit.objetivo')
                            ->assertViewHas('plano');
    }
    public function test_route_plano_avaliacao_post(){
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

        $avaliacao = ['avaliacao' => "Campo de avaliacao", 'plano_id' => $plano->id];
    
        $response = $this->actingAs($user)->json('POST', 'planos/avaliacao', $avaliacao)
                        ->assertStatus(302)
                        ->assertRedirect('/planos/'.$plano->id.'/avaliacoes');
                        
        $plano_retrieved = \App\Plano::find($plano->id);
        $this->assertEquals('Campo de avaliacao', $plano_retrieved->avaliacao);
        $this->assertEquals('Em Edição', $plano_retrieved->status);
        
        $response->assertSessionHas('plano', $plano_retrieved);                                     
    }
    public function test_route_plano_metodologia_post(){
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

        $metodologia = ['metodologia' => "Campo de metodologia", 'plano_id' => $plano->id];


        $response = $this->actingAs($user)->json('POST', 'planos/metodologia', $metodologia)
                        ->assertStatus(302)
                        ->assertRedirect('/planos/'.$plano->id.'/metodologias');
                        
        $plano_retrieved = \App\Plano::find($plano->id);
        $this->assertEquals('Campo de metodologia', $plano_retrieved->metodologia);
        $this->assertEquals('Em Edição', $plano_retrieved->status);
        
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_plano_objetivo_post(){
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

        $objetivo = ['objetivo' => "Campo de objetivo", 'plano_id' => $plano->id];


        $response = $this->actingAs($user)->json('POST', 'planos/objetivo', $objetivo)
                        ->assertStatus(302)
                        ->assertRedirect('/planos/'.$plano->id.'/objetivos');
                        
        $plano_retrieved = \App\Plano::find($plano->id);
        $this->assertEquals('Campo de objetivo', $plano_retrieved->objetivo);
        $this->assertEquals('Em Edição', $plano_retrieved->status);
        
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_plano_observacao_post(){
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

        $observacao = ['observacoes' => "Campo de observacao", 'plano_id' => $plano->id];

        $response = $this->actingAs($user)->json('POST', 'planos/observacao', $observacao)
                        ->assertStatus(302)
                        ->assertRedirect('/planos/'.$plano->id.'/exames');
                        
        $plano_retrieved = \App\Plano::find($plano->id);
        $this->assertEquals('Campo de observacao', $plano_retrieved->observacoes);
        $this->assertEquals('Em Edição', $plano_retrieved->status);
        
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_plano_view(){
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
        
        $response = $this->json('GET', 'view/'. $plano->id)
                            ->assertStatus(200)
                            ->assertViewIs('planos.show_noAuth')
                            ->assertViewHas('plano');
    }
    public function test_route_plano_search_get(){
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

        $busca = ['busca' => "programacao"];
        $response = $this->actingAs($user)->json('GET', 'search', $busca)
                        ->assertStatus(200)
                        ->assertViewIs('planos.index_noAuth')
                        ->assertViewHas('planos');                   
    }
    public function test_route_plano_export_get(){
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
        
        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id.'/export')
                        ->assertStatus(200)
                        ->assertViewIs('planos.export')
                        ->assertViewHas(['pOrign', 'planos_user']);                   
    }
    public function test_route_plano_view_pend(){
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
        
        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id.'/view_pend')
                        ->assertStatus(200)
                        ->assertViewIs('planos.view_pend')
                        ->assertViewHas(['plano', 'pendencias']);     
    }
    public function test_route_plano_pendencia(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $user2 = factory(\App\User::class)->create();
        $user2->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);
        
        $response = $this->actingAs($user2)->json('GET', 'planos/'. $plano->id.'/pendencia')
                        ->assertStatus(200)
                        ->assertViewIs('planos.reg_pend')
                        ->assertViewHas(['plano', 'pendencias']);
    }
    public function test_route_plano_planTipo(){
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

        $planTipo = ['id'=> $plano->id, 'tipo' => '2'];
        
        $response = $this->actingAs($user)->json('POST', 'planTipo', $planTipo)
                        ->assertStatus(200);
                    
        $plano_retrieved = \App\Plano::get()->first();
        $this->assertEquals('2', $plano_retrieved->tipo);
    }
    public function test_route_plano_registrarPend(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $user2 = factory(\App\User::class)->create();
        $user2->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id
        ]);

        $pendencia = [
            'plano_id' => $plano->id,
            'pendencia' => 'Anotações sobre as pendencias do plano correspondente',
        ];
        
        $response = $this->actingAs($user2)->json('POST', 'planos/registrarPendencia', $pendencia)
                        ->assertStatus(302)
                        ->assertRedirect('aprovacao');
                    
        $pendencia_retrieved = \App\Pendencia::get()->first();
        $this->assertEquals($plano->id, $pendencia_retrieved->plano_id);
        $this->assertEquals('Anotações sobre as pendencias do plano correspondente', $pendencia_retrieved->pendencia);
    }
    public function test_route_turma_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $response = $this->actingAs($user)->json('GET', 'planos/create')
                        ->assertStatus(200)
                        ->assertViewIs('planos.create')
                        ->assertViewHas(['users', 'semestres', 'disciplinas', 'cursos']);
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
        
        $response = $this->actingAs($user)->json('DELETE', 'planos/'.$plano->id, ['id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos');
            
        $this->assertDatabaseMissing('planos', ['id' => $plano->id]);
        
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
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id,
        ]);
        $disciplina->cursos()->attach($curso);

        $plano = [
            'user_id' => [$user->id],
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id,
            'horario' => [
                0 => '1',
                1 => '3',
            ],
        ];

        $response = $this->actingAs($user)->json('POST', 'planos', $plano)
                        ->assertStatus(302)
                        ->assertRedirect('/planos');

        $turma_retrieved = \App\Turma::get()->first();
        $this->assertEquals($disciplina->id, $turma_retrieved->disciplina_id);
        $this->assertEquals($curso->id, $turma_retrieved->curso_id);
        $this->assertEquals($semestre->id, $turma_retrieved->semestre_id);
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
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id,
        ]);
        $disciplina->cursos()->attach($curso);

        $turma = factory(\App\Turma::class)->create([
            'tipo_turma' => '0',
            'disciplina_id' => $disciplina->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id,
        ]);
        $turma->users()->attach($user->id);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'tipo' => '1',
            'status' => 'Em Edição',
        ]);

        $disciplina2 = factory(\App\Disciplina::class)->create([
            'codigo' => 'CSI488',
            'nome' => 'ALGORITMOS E ESTRUTURA DE DADOS I',
            'name' => 'ALGORITHMS AND DATA STRUCTURE I',
            'chsemestral'=>'60',
            'chsemanalp'=>'2',
            'chsemanalt'=>'2',
            'departamento_id' => $departamento->id
        ]);
        $disciplina2->cursos()->attach($curso);

        $turma_edited = [
            'user_id' => [$user->id],
            'tipo_turma' => '1',
            'disciplina_id' => $disciplina2->id,
            'curso_id' => $curso->id,
            'semestre_id' => $semestre->id,
            'horario' => [
                0 => '2',
                1 => '4',
            ],
        ];

        $planoId = $turma->planos()->first()->id;
        $response = $this->actingAs($user)->json('PATCH', 'planos/'. $planoId, $turma_edited)
                        ->assertStatus(302)
                        ->assertRedirect('/planos');
        
        $turma_retrieved = \App\Turma::get()->first();
        $this->assertEquals('1', $turma_retrieved->tipo_turma);
        $this->assertEquals($disciplina2->id, $turma_retrieved->disciplina_id);
        
        $horario = $turma_retrieved->horarios()->pluck('dia');
        $this->assertEquals($horario[0], '2');
        $this->assertEquals($horario[1], '4');
    }
    public function test_route_plano_aprovacao(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'status' => 'Em Análise'
        ]);

        $response = $this->actingAs($user)->json('GET', '/aprovacao')
                        ->assertStatus(200)
                        ->assertViewIs('planos.aprovacao')
                        ->assertViewHas('planos');       
        
        $content = $response->getOriginalContent()->getData();
        $plano_retrieved = $content['planos']->all();
        $this->assertEquals($plano_retrieved[0]->id, $plano->id);
    }
    public function test_route_aprovar(){
        $user1 = factory(\App\User::class)->create();
        $user1->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $user2= factory(\App\User::class)->create();
        $user2->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $semestre = factory(\App\Semestre::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();

        $turma = factory(\App\Turma::class)->create();
        $turma->users()->attach($user2);

        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'status' => 'Em Análise'
        ]);

        $response = $this->actingAs($user1)->json('GET', '/aprovar/'.$plano->id)
                        ->assertStatus(302)
                        ->assertRedirect('/aprovacao');;

        $plano_retrieved = \App\Plano::find($plano->id);
        $this->assertEquals($plano_retrieved->status, 'Aprovado');
    }    
    public function test_route_plano_export_post(){
        $user= factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        //__________________________________________________________________________________>>
        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();
        $semestre1 = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $turma1 = factory(\App\Turma::class)->create([
            'disciplina_id' => $disciplina->id,
            'semestre_id' => $semestre1->id,
            'curso_id' => $curso->id,
            'tipo_turma' => 0,
            'numero_turma' => 21,
        ]);
        $turma1->users()->attach($user);
        $planoOrign = factory(\App\Plano::class)->create([
            'turma_id' => $turma1->id,
            'status' => 'Aprovado',
            'objetivo' => 'Campo de objetivo',
            'metodologia' => 'Campo de metologia',
            'avaliacao' => 'Campo de avaliacao',
            'observacoes' => 'Campo de observacoes',
            'tipo' => 2
        ]);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma1->id;
            $horario->dia = $h;
            $horario->save();
        }
        
        $exame1 = new \App\Exame;
        $exame1->descricao = 'Prova 1';
        $exame1->peso = 20;
        $exame1->data = '2018-03-20';
        $exame1->conteudo = 'Conteudo da prova1';
        $exame1->plano_id = $planoOrign->id;
        $exame1->save();

        $exame2 = new \App\Exame;
        $exame2->descricao = 'Prova 2';
        $exame2->peso = 30;
        $exame2->data = '2018-05-20';
        $exame2->conteudo = 'Conteudo da prova2';
        $exame2->plano_id = $planoOrign->id;
        $exame2->save();

        $exame3 = new \App\Exame;
        $exame3->descricao = 'Prova 3';
        $exame3->peso = 15;
        $exame3->data = '2018-07-20';
        $exame3->conteudo = 'Conteudo da prova3';
        $exame3->plano_id = $planoOrign->id;
        $exame3->save();

        $plan1 = new \App\PlanejamentoAula;
        $plan1->aula = 1;
        $plan1->tipo  = 'T';
        $plan1->data  = '2018-03-12';
        $plan1->conteudo = 'Conteudo da Aula1';
        $plan1->plano_id  = $planoOrign->id;
        $plan1->save(); 

        $plan2 = new \App\PlanejamentoUnidade; 
        $plan2->unidade = 1;
        $plan2->hora_aula = 10;
        $plan2->descricao  = 'Conteudo da Unidade 1';
        $plan2->plano_id = $planoOrign->id;
        $plan2->save();
        
        //___________________________________________________>>
        $semestre2 = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/2',
            'inicio' => '2018-08-01',
            'fim' => '2018-12-20',
        ]);
        $turma2 = factory(\App\Turma::class)->create([
            'disciplina_id' => $disciplina->id,
            'semestre_id' => $semestre2->id,
            'curso_id' => $curso->id,
            'tipo_turma' => 0,
            'numero_turma' => 21,
        ]);
        $turma2->users()->attach($user);
        $planoDestiny = factory(\App\Plano::class)->create([
            'turma_id' => $turma2->id,
            'status' => 'Em Edição'
        ]);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma2->id;
            $horario->dia = $h;
            $horario->save();
        }
        //___________________________________________________>>

        $request = [
          'pOrign' => $planoOrign->id,
          'pDestiny' => $planoDestiny->id
        ];
        $response = $this->actingAs($user)->json('POST', '/planos/export', $request)
                    ->assertStatus(302)
                    ->assertRedirect('/planos');
     
        $plano_retrieved = \App\Plano::find($planoDestiny->id);
        $this->assertEquals($plano_retrieved->objetivo, 'Campo de objetivo');
        $this->assertEquals($plano_retrieved->metodologia, 'Campo de metologia');
        $this->assertEquals($plano_retrieved->avaliacao, 'Campo de avaliacao');
        $this->assertEquals($plano_retrieved->observacoes, 'Campo de observacoes');
        $this->assertEquals($plano_retrieved->tipo, 2);
        //_______________________________________________________________________________________________________>>
        $this->assertEquals($plano_retrieved->exames()->get()[0]->descricao, 'Prova 1');
        $this->assertEquals($plano_retrieved->exames()->get()[0]->peso, 20);
        $this->assertEquals($plano_retrieved->exames()->get()[0]->data, null);
        $this->assertEquals($plano_retrieved->exames()->get()[0]->conteudo, 'Conteudo da prova1');

        $this->assertEquals($plano_retrieved->exames()->get()[1]->descricao, 'Prova 2');
        $this->assertEquals($plano_retrieved->exames()->get()[1]->peso, 30);
        $this->assertEquals($plano_retrieved->exames()->get()[1]->data, null);
        $this->assertEquals($plano_retrieved->exames()->get()[1]->conteudo, 'Conteudo da prova2');

        $this->assertEquals($plano_retrieved->exames()->get()[2]->descricao, 'Prova 3');
        $this->assertEquals($plano_retrieved->exames()->get()[2]->peso, 15);
        $this->assertEquals($plano_retrieved->exames()->get()[2]->data, null);
        $this->assertEquals($plano_retrieved->exames()->get()[2]->conteudo, 'Conteudo da prova3');
        //_______________________________________________________________________________________________________>> 
        $this->assertEquals($plano_retrieved->planejamentoAulas()->first()->aula, 1);
        $this->assertEquals($plano_retrieved->planejamentoAulas()->first()->tipo, 'T');
        $this->assertEquals($plano_retrieved->planejamentoAulas()->first()->data, '01-08-2018');
        $this->assertEquals($plano_retrieved->planejamentoAulas()->first()->conteudo, 'Conteudo da Aula1');

        $this->assertEquals($plano_retrieved->planejamentoUnidades()->first()->unidade, 1);
        $this->assertEquals($plano_retrieved->planejamentoUnidades()->first()->hora_aula, 10);
        $this->assertEquals($plano_retrieved->planejamentoUnidades()->first()->descricao, 'Conteudo da Unidade 1');
    }
    public function test_route_plano_verificacao1(){
        $user= factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        //__________________________________________________________________________________>>
        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $turma = factory(\App\Turma::class)->create([
            'disciplina_id' => $disciplina->id,
            'semestre_id' => $semestre->id,
            'curso_id' => $curso->id,
            'tipo_turma' => 0,
            'numero_turma' => 21,
        ]);
        $turma->users()->attach($user);
        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'status' => 'Em Edição',
            'objetivo' => null,
            'metodologia' => null,
            'avaliacao' => null,
            'observacoes' => 'Campo de observacoes',
            'tipo' => 2
        ]);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }   

        $request = ['id' => $plano->id];
        $response = $this->actingAs($user)->json('GET', '/planos/'.$plano->id.'/verificacao', $request)
                ->assertStatus(302)
                ->assertRedirect('/')
                ->assertSessionHasErrors([
                    'soma_menor100'=> 'A pontuação total de avaliação se encontra com peso menor do que 100pts.',
                    'planejamento_empty' => 'Não há registro salvo na seção de planejamento.',
                    'avaliacao_empty'=> 'Não há informação salva na seção de Atividades Avaliativas.',
                    'metodologia_empty'=> 'Não há informação salva na seção de Metodologia.',
                    'objetivo_empty'=> 'Não há informação salva na seção de Objetivos.',
                ]);
    }
    public function test_route_plano_verificacao(){
        $user= factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        //__________________________________________________________________________________>>
        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $turma = factory(\App\Turma::class)->create([
            'disciplina_id' => $disciplina->id,
            'semestre_id' => $semestre->id,
            'curso_id' => $curso->id,
            'tipo_turma' => 0,
            'numero_turma' => 21,
        ]);
        $turma->users()->attach($user);
        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'status' => 'Em Edição',
            'tipo' => 1
        ]);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }   

        $troca = new \App\Troca;
        $troca->dia = '2018-03-14';
        $troca->substituicao = 'Sexta-Feira';
        $troca->semestre_id = $semestre->id;
        $troca->save();
        
        $plan1 = new \App\PlanejamentoAula;
        $plan1->aula = 1;
        $plan1->tipo  = 'T';
        $plan1->data  = '2018-03-13';
        $plan1->conteudo = 'Conteudo da Aula1';
        $plan1->plano_id  = $plano->id;
        $plan1->save(); 

        $plan2 = new \App\PlanejamentoAula;
        $plan2->aula = 2;
        $plan2->tipo  = 'P';
        $plan2->data  = '2018-03-14';
        $plan2->conteudo = 'Conteudo da Aula2';
        $plan2->plano_id  = $plano->id;
        $plan2->save(); 

        $plan3 = new \App\PlanejamentoAula;
        $plan3->aula = 3;
        $plan3->tipo  = 'T/P';
        $plan3->data  = null;
        $plan3->conteudo = 'Conteudo da Aula3';
        $plan3->plano_id  = $plano->id;
        $plan3->save(); 

        $exame1 = new \App\Exame;
        $exame1->descricao = 'Prova 1';
        $exame1->peso = 20;
        $exame1->data = null;
        $exame1->conteudo = 'Conteudo da prova1';
        $exame1->plano_id = $plano->id;
        $exame1->save();

        $request = ['id' => $plano->id];
        $response = $this->actingAs($user)->json('GET', '/planos/'.$plano->id.'/verificacao', $request)
                ->assertStatus(302)
                ->assertRedirect('/')
                ->assertSessionHasErrors([
                    'planejamento_substituicao'=> 'Um registro na tabela de planejamento possui data inválida para os dias letivos da turma.',
                    'planejamento_substituicao'=> 'Uma aula está marcada para um dia de substituição letiva. O dia da semana em questão é inválido como dia letivo da turma.',
                    'exame_campoVazio'=> 'Tabela de exames com campos vazios.',
                    'planejamento_campoVazio'=> 'Tabela de planejamento com campos vazios.',
                ]);
    }
    public function test_route_plano_warning(){
        $user= factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        //__________________________________________________________________________________>>
        $curso = factory(\App\Curso::class)->create();
        $departamento = factory(\App\Departamento::class)->create();
        $disciplina = factory(\App\Disciplina::class)->create();
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $turma = factory(\App\Turma::class)->create([
            'disciplina_id' => $disciplina->id,
            'semestre_id' => $semestre->id,
            'curso_id' => $curso->id,
            'tipo_turma' => 0,
            'numero_turma' => 21,
        ]);
        $turma->users()->attach($user);
        $plano = factory(\App\Plano::class)->create([
            'turma_id' => $turma->id,
            'status' => 'Em Edição',
            'tipo' => 1
        ]);
        foreach ([0=>"1", 1=>"3"] as $h) {
            $horario = new \App\Horario;
            $horario->turma_id = $turma->id;
            $horario->dia = $h;
            $horario->save();
        }

        $exame1 = new \App\Exame;
        $exame1->descricao = 'Prova 1';
        $exame1->peso = 80;
        $exame1->data = '2018-03-20';
        $exame1->conteudo = 'Conteudo da prova1';
        $exame1->plano_id = $plano->id;
        $exame1->save();

        $plan = new \App\PlanejamentoAula;
        $plan->aula = 1;
        $plan->tipo  = 'T/P';
        $plan->data  = '2018-03-12';
        $plan->conteudo = 'Conteudo da Aula1';
        $plan->plano_id  = $plano->id;
        $plan->save(); 

        $request = ['id' => $plano->id];
        $response = $this->actingAs($user)->json('GET', '/planos/'.$plano->id.'/warnings', $request)
                ->assertStatus(200)
                ->assertJson([
                    'peso_50'=>'Uma avaliação está com peso maior do que 50pts. É necessário possuir autorização prévia do colegiado do curso correspondente!',
                    'planejamento_hora'=> 'A quantidade de hora registrada no planejamento não corresponde ao total recomendado pela disciplina.',
                ]);
    }
}


