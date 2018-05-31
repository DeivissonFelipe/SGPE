<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrocaTest extends TestCase{
    use DataBaseTransactions;

    public function test_route_troca_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create();
        $trocas = factory(\App\Troca::class, 2)->create();
        $response = $this->actingAs($user)->json('GET', 'trocas/')
                        ->assertStatus(200)
                        ->assertViewIs('trocas.index')
                        ->assertViewHas('trocas');   
    }
    public function test_route_troca_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create();
        $response = $this->actingAs($user)->json('GET', 'trocas/create')
                        ->assertStatus(200)
                        ->assertViewIs('trocas.create');   
    }
    public function test_route_troca_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $troca = [
            'dia' => '2018-05-29',
            'substituicao' => "Segunda-Feira",
            'semestre_id' =>  $semestre->id,
        ];
        
        $response = $this->actingAs($user)->json('POST', 'trocas', $troca)
                        ->assertStatus(302)
                        ->assertRedirect('trocas');

        $troca_retrieved = \App\Troca::get()->first();
        $this->assertEquals('29-05-2018', $troca_retrieved->dia);
        $this->assertEquals('Segunda-Feira', $troca_retrieved->substituicao);
    }
    public function test_route_troca_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $troca = factory(\App\Troca::class)->create([
            'dia' => '2018-05-29',
            'substituicao' => "Segunda-Feira",
            'semestre_id' =>  $semestre->id, 
        ]);
        
        $troca_id = \App\Troca::get()->first()->id;

        $response = $this->actingAs($user)->json('GET', 'trocas/'.$troca_id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('trocas.edit')
                        ->assertViewHas('troca');
    }
    public function test_route_troca_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $troca = factory(\App\Troca::class)->create([
            'dia' => '2018-05-29',
            'substituicao' => "Segunda-Feira",
            'semestre_id' =>  $semestre->id, 
        ]);
        
        $troca_edited = [
            'dia' => '2018-05-29',
            'substituicao' => "Quarta-Feira",
            'semestre_id' =>  $semestre->id, 
        ];

        $response = $this->actingAs($user)->json('PATCH', 'trocas/'.$troca->id, $troca_edited)
                        ->assertStatus(302)
                        ->assertRedirect('trocas');

        $troca_retrieved = \App\Troca::get()->first();
        $this->assertEquals('Quarta-Feira', $troca_retrieved->substituicao);
    }
    public function test_route_troca_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);

        $troca = factory(\App\Troca::class)->create([
            'dia' => '2018-05-29',
            'substituicao' => "Segunda-Feira",
            'semestre_id' =>  $semestre->id, 
        ]);
        
        $response = $this->actingAs($user)->json('DELETE', 'trocas/'.$troca->id)
                        ->assertStatus(302)
                        ->assertRedirect('trocas');

        $this->assertDatabaseMissing('trocas', ['id' => $troca->id]);
    }
}
