<?php

use Illuminate\Database\Seeder;
use App\Semestre;
use Carbon\Carbon;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semestres')->insert([
            'rotulo' => '2018/1',
            'inicio' => Carbon::create('2018', '03', '12'),
            'fim' => Carbon::create('2018', '07', '21')
        ]);

        DB::table('semestres')->insert([
            'rotulo' => '2018/2',
            'inicio' => Carbon::create('2018', '08', '13'),
            'fim' => Carbon::create('2018', '12', '22')
        ]);

        // $Semestre = new Semestre();
        // $Semestre->rotulo = '2018/1';
        // $Semestre->inicio = Carbon::create('2018', '03', '12');
        // $Semestre->fim = Carbon::create('2018', '07', '21');
        // $Semestre->save();
    }
}

