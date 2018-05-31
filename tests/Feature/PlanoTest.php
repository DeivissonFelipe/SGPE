<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanoTest extends TestCase
{
    use DatabaseTransactions;

    // public function test_route_plano_index(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));        

    //     $plano = factory(\App\User::class)->create();
    //     $response = $this->actingAs($user)->json('GET', 'planos/')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.index')
    //                         ->assertViewHas('planos');
    // }
    // public function test_route_plano_show(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);
    //     $this->assertDatabaseHas('planos', ['id' => $plano->id]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id)
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.show')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_edit(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);
    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/edit')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.edit')
    //                         ->assertViewHas('plano');
        
    //     $plano_retrieved = $response->original->getData()['plano'];
    //     $this->assertInstanceOf('App\Plano', $plano_retrieved);
    //     $this->assertEquals($plano_retrieved->id, $plano->id);
    // }
    // public function test_route_plano_atendimentos(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/atendimentos')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.atendimento')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_exames(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
        
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/exames')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.exame')
    //                         ->assertViewHas(['plano','semestre','diasNaoLetivos']);
    // }
    // public function test_route_plano_planejamentos(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
     
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/planejamentos')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.planejamento')
    //                         ->assertViewHas(['plano','semestre','diasNaoLetivos']);
    // }  
    // public function test_route_plano_aula(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/aula')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.horario')
    //                         ->assertViewHas(['plano','semestre','diasNaoLetivos']);
    // }
    // public function test_route_plano_avaliacao_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/avaliacoes')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.avaliacao')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_bibliografia_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/bibliografias')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.bibliografia')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_conteudo_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
     
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/conteudos')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.conteudo')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_metodologia_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/metodologias')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.metodologia')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_ementa_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
    
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/ementas')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.ementa')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_objetivo_get(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));
     
    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/objetivos')
    //                         ->assertStatus(200)
    //                         ->assertViewIs('planos.partials-edit.objetivo')
    //                         ->assertViewHas('plano');
    // }
    // public function test_route_plano_avaliacao_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $avaliacao = ['avaliacao' => "Campo de avaliacao", 'plano_id' => $plano->id];
    
    //     $response = $this->actingAs($user)->json('POST', 'planos/avaliacao', $avaliacao)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de avaliacao', $plano_retrieved->avaliacao);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);                                     
    // }
    // public function test_route_plano_bibliografiab_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $bibliografiab = ['bibliografiab' => "Campo de bibliografiab", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/bibliografiab', $bibliografiab)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/bibliografias');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de bibliografiab', $plano_retrieved->bibliografiab);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
    // public function test_route_plano_bibliografiac_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $bibliografiac = ['bibliografiac' => "Campo de bibliografiac", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/bibliografiac', $bibliografiac)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/bibliografias');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de bibliografiac', $plano_retrieved->bibliografiac);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);   
    // }
    // public function test_route_plano_conteudo_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $conteudo = ['conteudo' => "Campo de conteudo", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/conteudo', $conteudo)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de conteudo', $plano_retrieved->conteudo);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
    // public function test_route_plano_metodologia_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $metodologia = ['metodologia' => "Campo de metodologia", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/metodologia', $metodologia)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de metodologia', $plano_retrieved->metodologia);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
    // public function test_route_plano_ementa_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $ementa = ['ementa' => "Campo de ementa", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/ementa', $ementa)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de ementa', $plano_retrieved->ementa);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
    // public function test_route_plano_objetivo_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $objetivo = ['objetivo' => "Campo de objetivo", 'plano_id' => $plano->id];


    //     $response = $this->actingAs($user)->json('POST', 'planos/objetivo', $objetivo)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de objetivo', $plano_retrieved->objetivo);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
    // public function test_route_plano_observacao_post(){
    //     $user = factory(\App\User::class)->create();
    //     $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Professor']));

    //     $curso = factory(\App\Curso::class)->create();
    //     $departamento = factory(\App\Departamento::class)->create();
    //     $semestre = factory(\App\Semestre::class)->create();
    //     $disciplina = factory(\App\Disciplina::class)->create();

    //     $turma = factory(\App\Turma::class)->create();
    //     $turma->users()->attach($user);

    //     $plano = factory(\App\Plano::class)->create([
    //         'turma_id' => $turma->id
    //     ]);

    //     $observacao = ['observacoes' => "Campo de observacao", 'plano_id' => $plano->id];

    //     $response = $this->actingAs($user)->json('POST', 'planos/observacao', $observacao)
    //                     ->assertStatus(302)
    //                     ->assertRedirect('/planos/'.$plano->id.'/edit');
                        
    //     $plano_retrieved = \App\Plano::find($plano->id);
    //     $this->assertEquals('Campo de observacao', $plano_retrieved->observacoes);
    //     $this->assertEquals('Em Edição', $plano_retrieved->status);
        
    //     $response->assertSessionHas('plano', $plano_retrieved);
    // }
 
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
        $response = $this->json('GET', 'search')
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
        $this->assertEquals('Anotações sobre as pendencias do plano correspondente', $pendencia_retrieved->pendencia);

    }

    
    
    
    
    
    // public function test_route_plano_search_post(){}
    // public function test_route_plano_export_post(){}
    // public function test_route_plano_verificacao(){}
    // public function test_route_plano_aprovacao(){}
    // public function test_route_plano_aprovacaoSemestre(){}
    // public function test_route_aprovar(){}
        
        
}
