<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class SemestreTest extends TestCase{
    use DataBaseTransactions;

    public function test_route_semestre_index(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestres = factory(\App\Semestre::class, 2)->create();
        $response = $this->actingAs($user)->json('GET', 'semestres/')
                        ->assertStatus(200)
                        ->assertViewIs('semestres.index')
                        ->assertViewHas('semestres');
    }
    public function test_route_semestre_create(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $response = $this->actingAs($user)->json('GET', 'semestres/create')
                        ->assertStatus(200)
                        ->assertViewIs('semestres.create');
    }
    public function test_route_semestre_store(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));
        
        $semestre = [
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ];
        
        $response = $this->actingAs($user)->json('POST', 'semestres', $semestre)
                        ->assertStatus(302)
                        ->assertRedirect('semestres');

        $semestre_retrieved = \App\Semestre::get()->first();
        $this->assertEquals('2018/1', $semestre_retrieved->rotulo);
        $this->assertEquals('12-03-2018', $semestre_retrieved->inicio);
        $this->assertEquals('21-07-2018', $semestre_retrieved->fim);
    }
    public function test_route_semestre_edit(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $semestre_id = \App\Semestre::get()->first()->id;

        $response = $this->actingAs($user)->json('GET', 'semestres/'.$semestre_id.'/edit')
                        ->assertStatus(200)
                        ->assertViewIs('semestres.edit')
                        ->assertViewHas('semestre');
    }
    public function test_route_semestre_update(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $semestre_id = \App\Semestre::get()->first()->id;

        $semestre_edited = [
            'rotulo' => '2018/2',
            'inicio' => '2018-08-01',
            'fim' => '2018-12-15',
        ];

        $response = $this->actingAs($user)->json('PATCH', 'semestres/'.$semestre_id, $semestre_edited)
                        ->assertStatus(302)
                        ->assertRedirect('semestres');

        $semestre_retrieved = \App\Semestre::find($semestre_id);
        $this->assertEquals('2018/2', $semestre_retrieved->rotulo);
        $this->assertEquals('01-08-2018', $semestre_retrieved->inicio);
        $this->assertEquals('15-12-2018', $semestre_retrieved->fim);                    
    }
    public function test_route_semestre_delete(){
        $user = factory(\App\User::class)->create();
        $user->roles()->attach(factory(\App\Role::class)->create(['name' => 'Admin']));

        $semestre = factory(\App\Semestre::class)->create([
            'rotulo' => '2018/1',
            'inicio' => '2018-03-12',
            'fim' => '2018-07-21',
        ]);
        $semestre_id = \App\Semestre::get()->first()->id;

        $response = $this->actingAs($user)->json('DELETE', 'semestres/'.$semestre_id)
                        ->assertStatus(302)
                        ->assertRedirect('semestres');

        $this->assertDatabaseMissing('semestres', ['id' => $semestre_id]);
    }
}
