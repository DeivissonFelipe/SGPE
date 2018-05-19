<?php

use Illuminate\Database\Seeder;
use App\Departamento;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$Departamento1 = new Departamento();
		$Departamento1->nome = 'Departamento de Engenharia de Produção';
     	$Departamento1->sigla = 'DEENP';
     	$Departamento1->save();

     	
		$Departamento2 = new Departamento();
		$Departamento2->nome = 'Departamento de Computação e Sistemas';
     	$Departamento2->sigla = 'DECSI';
     	$Departamento2->save();

		$Departamento3 = new Departamento();
		$Departamento3->nome = 'Departamento de Engenharia Elétrica';
     	$Departamento3->sigla = 'DEELT';
     	$Departamento3->save();
        
		$Departamento4 = new Departamento();
		$Departamento4->nome = 'Departamento de Ciências Exatas e Aplicadas';
     	$Departamento4->sigla = 'DECEA';
     	$Departamento4->save();
    }
}
