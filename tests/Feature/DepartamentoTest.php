<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartamentoTest extends TestCase{
    use DatabaseTransactions;

    public function test_route_departamento_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $departamentos = factory(\App\Departamento::class, 4)->create();

        $response = $this->actingAs($user)->json('GET', 'departamentos/')
                        ->assertStatus(200)
                        ->assertViewIs('departamentos.index')
                        ->assertViewHas('departamentos');
    }
    public function test_route_departamento_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $response = $this->actingAs($user)->json('GET', 'departamentos/create')
                        ->assertStatus(200)
                        ->assertViewIs('departamentos.create');
    }
    public function test_route_departamento_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $departamento = [
            'nome' => 'Departamento de Computação e Sistemas',
            'sigla' => 'DECSI'
        ];
        $response = $this->actingAs($user)->json('POST', 'departamentos', $departamento)
                        ->assertStatus(302)
                        ->assertRedirect('/departamentos');

        $departamento_retrieved = \App\Departamento::get()->first();
        $this->assertEquals('Departamento de Computação e Sistemas', $departamento_retrieved->nome);
        $this->assertEquals('DECSI', $departamento_retrieved->sigla);
    }
    public function test_route_departamento_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $departamento = factory(\App\Departamento::class)->create([
            'nome' => 'Departamento de Computação e Sistemas',
            'sigla' => 'DECSI'
        ]);
        $departamento_id = \App\Departamento::get()->first()->id;
        $response = $this->actingAs($user)->json('GET', 'departamentos/'.$departamento_id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('departamentos.edit')
                        ->assertViewHas('departamento');
    }
    public function test_route_departamento_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        $departamento = factory(\App\Departamento::class)->create([
            'nome' => 'Departamento de Computação e Sistemas',
            'sigla' => 'DECSI'
        ]);
        $departamento_id = \App\Departamento::get()->first()->id;

        $departamento_edited = [
            'nome' => 'Departamento de Ciências Exatas e Aplicadas',
            'sigla' => 'DECEA'
        ];
        $response = $this->actingAs($user)->json('PATCH', 'departamentos/'. $departamento_id, $departamento_edited)
                        ->assertStatus(302)
                        ->assertRedirect('/departamentos');
        
        $departamento_retrieved = \App\Departamento::get()->first();
        $this->assertEquals('Departamento de Ciências Exatas e Aplicadas', $departamento_retrieved->nome);
        $this->assertEquals('DECEA', $departamento_retrieved->sigla);
    }
    public function test_route_departamento_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $departamento = factory(\App\Departamento::class)->create([
            'nome' => 'Departamento de Computação e Sistemas',
            'sigla' => 'DECSI'
        ]);
        $departamento_id = \App\Departamento::get()->first()->id;
        
        $response = $this->actingAs($user)->json('DELETE', 'departamentos/'.$departamento_id, ['id' => $departamento_id])
            ->assertStatus(302)
            ->assertRedirect('/departamentos');
            
        $this->assertDatabaseMissing('departamentos', ['id' => $departamento_id]);
    }

}
