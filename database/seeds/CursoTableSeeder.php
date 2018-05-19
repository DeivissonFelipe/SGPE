<?php

use Illuminate\Database\Seeder;
use App\Curso;

class CursoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$curso1 = new Curso();
		$curso1->id = '1';
     	$curso1->nome = 'Engenharia de Produção';
     	$curso1->sigla = 'EP';
     	$curso1->save();
     	
		$curso2 = new Curso();
		$curso2->id = '2';
     	$curso2->nome = 'Sistemas de Informação';
     	$curso2->sigla = 'SI';
     	$curso2->save();

		$curso3 = new Curso();
		$curso3->id = '3';
     	$curso3->nome = 'Engenharia Elétrica';
     	$curso3->sigla = 'EE';
     	$curso3->save();
        
		$curso4 = new Curso();
		$curso4->id = '4';
     	$curso4->nome = 'Engenharia de Computação';
     	$curso4->sigla = 'EC';
     	$curso4->save();
    }
}
