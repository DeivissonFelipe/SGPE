<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ExameTest extends TestCase{
    use DatabaseTransactions;

    public function test_route_plano_exames(){
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

        $response = $this->actingAs($user)->json('GET', 'planos/'. $plano->id . '/exames')
                            ->assertStatus(200)
                            ->assertViewIs('planos.partials-edit.exame')
                            ->assertViewHas(['plano','semestre','diasNaoLetivos']);
    }
    public function test_route_exame_store(){
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

        $exame = [
            'descricao' => 'Avaliação 1',
            'peso' => '20',
            'data' => '2018-05-23',
            'conteudo' => 'Todo conteúdo da aula 1 até a aula 20',
            'plano_id' => $plano->id
        ];

        $response = $this->actingAs($user)->json('POST', 'exames', $exame)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/exames');
        

        $exame_retrieved = \App\Exame::get()->first();
        $this->assertEquals('Avaliação 1', $exame_retrieved->descricao);
        $this->assertEquals('20', $exame_retrieved->peso);
        $this->assertEquals('23-05-2018', $exame_retrieved->data);
        $this->assertEquals('Todo conteúdo da aula 1 até a aula 20', $exame_retrieved->conteudo);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_exame_update(){
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

        $exame = factory(\App\Exame::class)->create([
            'descricao' => 'Avaliação 1',
            'peso' => '20',
            'data' => '2018-05-20',
            'conteudo' => 'Todo conteúdo da aula 1 até a aula 20',
            'plano_id' => $plano->id
        ]);

        $exame_id = \App\Exame::get()->first()->id;

        $exame_edited = [
            'id' => $exame_id,
            'descricao' => 'Avaliação 2',
            'peso' => '30',
            'data' => '2018-05-23',
            'conteudo' => 'Todo conteúdo da aula 21 até a aula 36',
            'plano_id' => $plano->id
        ];


        $response = $this->actingAs($user)->json('PATCH', 'exames/'.$exame_id, $exame_edited)
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/exames');
        

        $exame_retrieved = \App\Exame::get()->first();
        $this->assertEquals('Avaliação 2', $exame_retrieved->descricao);
        $this->assertEquals('30', $exame_retrieved->peso);
        $this->assertEquals('23-05-2018', $exame_retrieved->data);
        $this->assertEquals('Todo conteúdo da aula 21 até a aula 36', $exame_retrieved->conteudo);

        $plano_retrieved = \App\Plano::find($plano->id);
        $response->assertSessionHas('plano', $plano_retrieved);
    }
    public function test_route_exame_delete(){
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
        
        $exame = factory(\App\Exame::class)->create([
            'descricao' => 'Avaliação 1',
            'peso' => '20',
            'data' => '2018-05-25',
            'conteudo' => 'Todo conteúdo da aula 1 até a aula 20',
            'plano_id' => $plano->id
        ]);

        $exame_id = \App\Exame::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'exames/'.$exame_id, ['plano_id' => $plano->id])
            ->assertStatus(302)
            ->assertRedirect('/planos/'.$plano->id.'/exames');
        
        $this->assertDatabaseMissing('exames', ['id' => $exame_id]);
    }   
}
