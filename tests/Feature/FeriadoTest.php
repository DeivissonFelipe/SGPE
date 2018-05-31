<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class FeriadoTest extends TestCase{
    use DataBaseTransactions;

    public function test_route_feriado_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create();
        $feriados = factory(\App\Feriado::class, 2)->create();
        $response = $this->actingAs($user)->json('GET', 'feriados/')
                        ->assertStatus(200)
                        ->assertViewIs('feriados.index')
                        ->assertViewHas('feriados');
    }
    public function test_route_feriado_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create();
        $response = $this->actingAs($user)->json('GET', 'feriados/create')
                        ->assertStatus(200)
                        ->assertViewIs('feriados.create');
    }
    public function test_route_feriado_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $feriado = [
            'data' => '2018-05-29',
            'semestre_id' =>  $semestre->id,
        ];
        
        $response = $this->actingAs($user)->json('POST', 'feriados', $feriado)
                        ->assertStatus(302)
                        ->assertRedirect('feriados');

        $feriado_retrieved = \App\Feriado::get()->first();
        $this->assertEquals('29-05-2018', $feriado_retrieved->data);
    }
    public function test_route_feriado_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $feriado = factory(\App\Feriado::class)->create([
            'data' => '2018-05-29',
            'semestre_id' =>  $semestre->id,
        ]);
        
        $feriado_id = \App\Feriado::get()->first()->id;

        $response = $this->actingAs($user)->json('GET', 'feriados/'.$feriado_id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('feriados.edit')
                        ->assertViewHas('feriado');
    }
    public function test_route_feriado_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        
        $feriado = factory(\App\Feriado::class)->create([
            'data' => '2018-05-29',
            'semestre_id' =>  $semestre->id,
        ]);
                
        $feriado_edited = [
            'id' => $feriado->id,
            'data' => '2018-05-30',
            'semestre_id' =>  $semestre->id,
        ];

        $response = $this->actingAs($user)->json('PATCH', 'feriados/'.$feriado->id, $feriado_edited)
                        ->assertStatus(302)
                        ->assertRedirect('feriados');

        $feriado_retrieved = \App\Feriado::get()->first();
        $this->assertEquals('30-05-2018', $feriado_retrieved->data);
    }
    public function test_route_feriado_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);

        $feriado = factory(\App\Feriado::class)->create([
            'data' => '2018-05-29',
            'semestre_id' =>  $semestre->id,
        ]);
        
        $feriado_id = \App\Feriado::get()->first()->id;


        $response = $this->actingAs($user)->json('DELETE', 'feriados/'.$feriado_id)
                        ->assertStatus(302)
                        ->assertRedirect('feriados');

        $this->assertDatabaseMissing('feriados', ['id' => $feriado_id]);
    }
}
