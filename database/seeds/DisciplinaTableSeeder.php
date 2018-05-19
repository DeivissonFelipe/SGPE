<?php

use Illuminate\Database\Seeder;
use App\Disciplina;

class DisciplinaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Disciplina1 = new Disciplina();
     	$Disciplina1->codigo = 'CEA036';
		$Disciplina1->nome = 'FUNDAMENTOS DE GEOMETRIA ANALITICA E ALGEBRA LINEAR';
		$Disciplina1->name = 'FUNDAMENTALS OF ANALYTICAL GEOMETRY AND LINEAR ALGEBRA';
		$Disciplina1->chsemestral = '60';
		$Disciplina1->chsemanalt = '4';
		$Disciplina1->chsemanalp = '0';
     	$Disciplina1->departamento_id = '4';
		$Disciplina1->save();
		$Disciplina1->cursos()->sync('1', false);
		$Disciplina1->cursos()->sync('2', false);
		$Disciplina1->cursos()->sync('3', false);
		$Disciplina1->cursos()->sync('4', false);
		//<Todos>--------------------------------------------------------------------------<>

     	$Disciplina2 = new Disciplina();
     	$Disciplina2->codigo = 'CEA423';
     	$Disciplina2->nome = 'FUNDAMENTOS DE CALCULO';
		$Disciplina2->name = 'CALCULATION FUNDAMENTALS';
		$Disciplina2->chsemestral = '60';
		$Disciplina2->chsemanalt = '4';
		$Disciplina2->chsemanalp = '0';
     	$Disciplina2->departamento_id = '4';
		$Disciplina2->save();
		$Disciplina2->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>

		$Disciplina3 = new Disciplina();
     	$Disciplina3->codigo = 'CSI030';
     	$Disciplina3->nome = 'PROGRAMACAO DE COMPUTADORES';
		$Disciplina3->name = 'COMPUTER PROGRAMMING';
		$Disciplina3->chsemestral = '60';
		$Disciplina3->chsemanalt = '2';
		$Disciplina3->chsemanalp = '2';
     	$Disciplina3->departamento_id = '2';
		$Disciplina3->save();
		$Disciplina3->cursos()->sync('1', false);
		$Disciplina3->cursos()->sync('2', false);
		$Disciplina3->cursos()->sync('3', false);
		$Disciplina3->cursos()->sync('4', false);
		//<Todos>--------------------------------------------------------------------------<>     	

     	$Disciplina4 = new Disciplina();
     	$Disciplina4->codigo = 'CSI145';
     	$Disciplina4->nome = 'TEORIA E FUNDAMENTOS DE SISTEMA DE INFORMACAO';
		$Disciplina4->name = 'INFORMATION SYSTEM THEORY AND FOUNDATIONS';
		$Disciplina4->chsemestral = '60';
		$Disciplina4->chsemanalt = '4';
		$Disciplina4->chsemanalp = '0';
     	$Disciplina4->departamento_id = '2';
		$Disciplina4->save();
		$Disciplina4->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<> 

     	$Disciplina5 = new Disciplina();
     	$Disciplina5->codigo = 'CSI427';
     	$Disciplina5->nome = 'METODOLOGIA DE PESQUISA APLICADA A COMPUTACAO';
		$Disciplina5->name = 'APPLIED COMPUTER RESEARCH METHODOLOGY';
		$Disciplina5->chsemestral = '60';
		$Disciplina5->chsemanalt = '2';
		$Disciplina5->chsemanalp = '0';
     	$Disciplina5->departamento_id = '2';
		$Disciplina5->save();
		$Disciplina5->cursos()->sync('2', false);
		$Disciplina5->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<> 

		$Disciplina6 = new Disciplina();
     	$Disciplina6->codigo = 'CSI491';
     	$Disciplina6->nome = 'INFORMATICA E SOCIEDADE';
		$Disciplina6->name = 'COMPUTERS AND SOCIETY';
		$Disciplina6->chsemestral = '60';
		$Disciplina6->chsemanalt = '2';
		$Disciplina6->chsemanalp = '0';
     	$Disciplina6->departamento_id = '2';
		$Disciplina6->save();
		$Disciplina6->cursos()->sync('2', false);
		$Disciplina6->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<> 
     
     	$Disciplina7 = new Disciplina();
     	$Disciplina7->codigo = 'CSI032';
     	$Disciplina7->nome = 'PROGRAMACAO DE COMPUTADORES II';
		$Disciplina7->name = 'COMPUTER PROGRAMMING II';
		$Disciplina7->chsemestral = '60';
		$Disciplina7->chsemanalt = '2';
		$Disciplina7->chsemanalp = '2';
     	$Disciplina7->departamento_id = '2';
		$Disciplina7->save();
		$Disciplina7->cursos()->sync('2', false);
		$Disciplina7->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<> 

     	$Disciplina8 = new Disciplina();
     	$Disciplina8->codigo = 'CSI443';
     	$Disciplina8->nome = 'MATEMATICA DISCRETA';
		$Disciplina8->name = 'DISCRETE MATHEMATICS';
		$Disciplina8->chsemestral = '60';
		$Disciplina8->chsemanalt = '4';
		$Disciplina8->chsemanalp = '0';
     	$Disciplina8->departamento_id = '2';
		$Disciplina8->save();
		$Disciplina8->cursos()->sync('2', false);
		$Disciplina8->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<> 
     	
     	$Disciplina9 = new Disciplina();
     	$Disciplina9->codigo = 'CSI460';
     	$Disciplina9->nome = 'GESTAO DA INFORMACAO';
		$Disciplina9->name = 'INFORMATION MANAGEMENT';
		$Disciplina9->chsemestral = '60';
		$Disciplina9->chsemanalt = '4';
		$Disciplina9->chsemanalp = '0';
     	$Disciplina9->departamento_id = '2';
		$Disciplina9->save();
		$Disciplina9->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
  		$Disciplina10 = new Disciplina();
     	$Disciplina10->codigo = 'CSI488';
     	$Disciplina10->nome = 'ALGORITMOS E ESTRUTURA DE DADOS I';
		$Disciplina10->name = 'ALGORITHMS AND DATA STRUCTURE I';
		$Disciplina10->chsemestral = '60';
		$Disciplina10->chsemanalt = '3';
		$Disciplina10->chsemanalp = '1';
     	$Disciplina10->departamento_id = '2';
		$Disciplina10->save();
		$Disciplina10->cursos()->sync('2', false);
		$Disciplina10->cursos()->sync('3', false);
		$Disciplina10->cursos()->sync('4', false);
		//<Computacao/Eletrica/Sistemas>--------------------------------------------------------------------------<>
   
     	$Disciplina11 = new Disciplina();
     	$Disciplina11->codigo = 'ENP144';
     	$Disciplina11->nome = 'TEORIA GERAL DA ADMINISTRACAO';
		$Disciplina11->name = 'GENERAL THEORY OF ADMINISTRATION';
		$Disciplina11->chsemestral = '60';
		$Disciplina11->chsemanalt = '4';
		$Disciplina11->chsemanalp = '0';
     	$Disciplina11->departamento_id = '1';
		$Disciplina11->save();
		$Disciplina11->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina12 = new Disciplina();
     	$Disciplina12->codigo = 'CEA307';
     	$Disciplina12->nome = 'ESTATISTICA E PROBABILIDADE';
		$Disciplina12->name = 'STATISTICS AND PROBABILITY';
		$Disciplina12->chsemestral = '60';
		$Disciplina12->chsemanalt = '4';
		$Disciplina12->chsemanalp = '0';
     	$Disciplina12->departamento_id = '4';
		$Disciplina12->save();
		$Disciplina12->cursos()->sync('2', false);
		$Disciplina12->cursos()->sync('3', false);
		$Disciplina12->cursos()->sync('4', false);
		//<Computacao/Eletrica/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina13 = new Disciplina();
     	$Disciplina13->codigo = 'CSI424';
     	$Disciplina13->nome = 'FUNDAMENTOS DE ARQUITETURA DE COMPUTADORES';
		$Disciplina13->name = 'FUNDAMENTALS OF COMPUTER ARCHITECTURE';
		$Disciplina13->chsemestral = '60';
		$Disciplina13->chsemanalt = '4';
		$Disciplina13->chsemanalp = '0';
     	$Disciplina13->departamento_id = '2';
		$Disciplina13->save();
		$Disciplina13->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina14 = new Disciplina();
     	$Disciplina14->codigo = 'CSI429';
     	$Disciplina14->nome = 'ALGORITMOS E ESTRUTURA DE DADOS II';
		$Disciplina14->name = 'ALGORITHMS AND DATA STRUCTURE II';
		$Disciplina14->chsemestral = '60';
		$Disciplina14->chsemanalt = '4';
		$Disciplina14->chsemanalp = '0';
     	$Disciplina14->departamento_id = '2';
		$Disciplina14->save();
		$Disciplina14->cursos()->sync('2', false);
		$Disciplina14->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina15 = new Disciplina();
     	$Disciplina15->codigo = 'CSI466';
     	$Disciplina15->nome = 'TEORIA DOS GRAFOS';
		$Disciplina15->name = 'THEORY OF GRAPHS';
		$Disciplina15->chsemestral = '60';
		$Disciplina15->chsemanalt = '4';
		$Disciplina15->chsemanalp = '0';
     	$Disciplina15->departamento_id = '2';
		$Disciplina15->save();
		$Disciplina15->cursos()->sync('2', false);
		$Disciplina15->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina16 = new Disciplina();
     	$Disciplina16->codigo = 'ENP473';
     	$Disciplina16->nome = 'COMPORTAMENTO ORGANIZACIONAL';
		$Disciplina16->name = 'ORGANIZATIONAL BEHAVIOR';
		$Disciplina16->chsemestral = '60';
		$Disciplina16->chsemanalt = '4';
		$Disciplina16->chsemanalp = '0';
     	$Disciplina16->departamento_id = '1';
		$Disciplina16->save();
		$Disciplina16->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina17 = new Disciplina();
     	$Disciplina17->codigo = 'CSI437';
     	$Disciplina17->nome = 'SISTEMAS OPERACIONAIS';
		$Disciplina17->name = 'OPERATIONAL SYSTEMS';
		$Disciplina17->chsemestral = '60';
		$Disciplina17->chsemanalt = '4';
		$Disciplina17->chsemanalp = '0';
     	$Disciplina17->departamento_id = '2';
		$Disciplina17->save();
		$Disciplina17->cursos()->sync('2', false);
		$Disciplina17->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina18 = new Disciplina();
     	$Disciplina18->codigo = 'CSI440';
     	$Disciplina18->nome = 'BANCO DE DADOS I';
		$Disciplina18->name = 'DATABASE I';
		$Disciplina18->chsemestral = '60';
		$Disciplina18->chsemanalt = '4';
		$Disciplina18->chsemanalp = '0';
     	$Disciplina18->departamento_id = '2';
		$Disciplina18->save();
		$Disciplina18->cursos()->sync('2', false);
		$Disciplina18->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina19 = new Disciplina();
     	$Disciplina19->codigo = 'CSI485';
     	$Disciplina19->nome = 'ENGENHARIA DE SOFTWARE I';
		$Disciplina19->name = 'SOFTWARE ENGINEERING I';
		$Disciplina19->chsemestral = '60';
		$Disciplina19->chsemanalt = '4';
		$Disciplina19->chsemanalp = '0';
     	$Disciplina19->departamento_id = '2';
		$Disciplina19->save();
		$Disciplina19->cursos()->sync('1', false);
		$Disciplina19->cursos()->sync('2', false);
		$Disciplina19->cursos()->sync('4', false);
		//<Computacao/Producao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina20 = new Disciplina();
     	$Disciplina20->codigo = 'ENP150';
     	$Disciplina20->nome = 'ECONOMIA';
		$Disciplina20->name = 'ECONOMY';
		$Disciplina20->chsemestral = '60';
		$Disciplina20->chsemanalt = '4';
		$Disciplina20->chsemanalp = '0';
     	$Disciplina20->departamento_id = '1';
		$Disciplina20->save();
		$Disciplina20->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina21 = new Disciplina();
     	$Disciplina21->codigo = 'ENP153';
     	$Disciplina21->nome = 'PROGRAMACAO LINEAR';
		$Disciplina21->name = 'LINEAR PROGRAMMING';
		$Disciplina21->chsemestral = '60';
		$Disciplina21->chsemanalt = '3';
		$Disciplina21->chsemanalp = '1';
     	$Disciplina21->departamento_id = '1';
		$Disciplina21->save();
		$Disciplina21->cursos()->sync('1', false);
		$Disciplina21->cursos()->sync('2', false);
		$Disciplina21->cursos()->sync('4', false);
		//<Computacao/Producao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina22 = new Disciplina();
     	$Disciplina22->codigo = 'CSI426';
     	$Disciplina22->nome = 'FUNDAMENTOS DE REDES DE COMPUTADORES';
		$Disciplina22->name = 'BASICS OF COMPUTER NETWORKS';
		$Disciplina22->chsemestral = '60';
		$Disciplina22->chsemanalt = '4';
		$Disciplina22->chsemanalp = '0';
     	$Disciplina22->departamento_id = '2';
		$Disciplina22->save();
		$Disciplina22->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina23 = new Disciplina();
     	$Disciplina23->codigo = 'CSI442';
     	$Disciplina23->nome = 'BANCO DE DADOS II';
		$Disciplina23->name = 'DATABASE II';
		$Disciplina23->chsemestral = '60';
		$Disciplina23->chsemanalt = '4';
		$Disciplina23->chsemanalp = '0';
     	$Disciplina23->departamento_id = '2';
		$Disciplina23->save();
		$Disciplina23->cursos()->sync('2', false);
		$Disciplina23->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina24 = new Disciplina();
     	$Disciplina24->codigo = 'CSI457';
     	$Disciplina24->nome = 'INTELIGENCIA ARTIFICIAL';
		$Disciplina24->name = 'ARTIFICIAL INTELLIGENCE';
		$Disciplina24->chsemestral = '60';
		$Disciplina24->chsemanalt = '4';
		$Disciplina24->chsemanalp = '0';
     	$Disciplina24->departamento_id = '2';
		$Disciplina24->save();
		$Disciplina24->cursos()->sync('1', false);
		$Disciplina24->cursos()->sync('2', false);
		$Disciplina24->cursos()->sync('4', false);
		//<Computacao/Producao/Sistemas>--------------------------------------------------------------------------<>
     	
	   	$Disciplina25 = new Disciplina();
     	$Disciplina25->codigo = 'CSI476';
     	$Disciplina25->nome = 'FUNDAMENTOS TEORICOS DA COMPUTACAO';
		$Disciplina25->name = 'THEORETICAL FOUNDATIONS OF COMPUTATION';
		$Disciplina25->chsemestral = '60';
		$Disciplina25->chsemanalt = '4';
		$Disciplina25->chsemanalp = '0';
     	$Disciplina25->departamento_id = '2';
		$Disciplina25->save();
		$Disciplina25->cursos()->sync('2', false);
		$Disciplina25->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina26 = new Disciplina();
     	$Disciplina26->codigo = 'CSI486';
     	$Disciplina26->nome = 'ENGENHARIA DE SOFTWARE II';
		$Disciplina26->name = 'SOFTWARE ENGINEERING II';
		$Disciplina26->chsemestral = '60';
		$Disciplina26->chsemanalt = '4';
		$Disciplina26->chsemanalp = '0';
     	$Disciplina26->departamento_id = '2';
		$Disciplina26->save();
		$Disciplina26->cursos()->sync('1', false);
		$Disciplina26->cursos()->sync('2', false);
		$Disciplina26->cursos()->sync('4', false);
		//<Computacao/Producao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina27 = new Disciplina();
     	$Disciplina27->codigo = 'CSI419';
     	$Disciplina27->nome = 'LINGUAGENS DE PROGRAMACAO';
		$Disciplina27->name = 'PROGRAMMING LANGUAGES';
		$Disciplina27->chsemestral = '60';
		$Disciplina27->chsemanalt = '4';
		$Disciplina27->chsemanalp = '0';
     	$Disciplina27->departamento_id = '2';
		$Disciplina27->save();
		$Disciplina27->cursos()->sync('2', false);
		$Disciplina27->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>   	

     	$Disciplina28 = new Disciplina();
     	$Disciplina28->codigo = 'CSI433';
     	$Disciplina28->nome = 'SISTEMAS DISTRIBUIDOS';
		$Disciplina28->name = 'DISTRIBUTED SYSTEMS';
		$Disciplina28->chsemestral = '60';
		$Disciplina28->chsemanalt = '4';
		$Disciplina28->chsemanalp = '0';
     	$Disciplina28->departamento_id = '2';
		$Disciplina28->save();
		$Disciplina28->cursos()->sync('2', false);
		$Disciplina28->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>
     	
     	$Disciplina29 = new Disciplina();
     	$Disciplina29->codigo = 'CSI450';
     	$Disciplina29->nome = 'INTERACAO HUMANO-COMPUTADOR';
		$Disciplina29->name = 'HUMAN-COMPUTER INTERACTION';
		$Disciplina29->chsemestral = '60';
		$Disciplina29->chsemanalt = '4';
		$Disciplina29->chsemanalp = '0';
     	$Disciplina29->departamento_id = '2';
		$Disciplina29->save();
		$Disciplina29->cursos()->sync('2', false);
		$Disciplina29->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina30 = new Disciplina();
     	$Disciplina30->codigo = 'CSI477';
     	$Disciplina30->nome = 'SISTEMAS WEB I';
		$Disciplina30->name = 'WEB SYSTEMS I';
		$Disciplina30->chsemestral = '60';
		$Disciplina30->chsemanalt = '2';
		$Disciplina30->chsemanalp = '2';
     	$Disciplina30->departamento_id = '2';
		$Disciplina30->save();
		$Disciplina30->cursos()->sync('2', false);
		$Disciplina30->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina31 = new Disciplina();
     	$Disciplina31->codigo = 'CSI735';
     	$Disciplina31->nome = 'GERENCIA DE PROJETOS DE SOFTWARE';
		$Disciplina31->name = 'SOFTWARE PROJECT MANAGEMENT';
		$Disciplina31->chsemestral = '60';
		$Disciplina31->chsemanalt = '4';
		$Disciplina31->chsemanalp = '0';
     	$Disciplina31->departamento_id = '2';
		$Disciplina31->save();
		$Disciplina31->cursos()->sync('2', false);
		$Disciplina31->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina32 = new Disciplina();
     	$Disciplina32->codigo = 'CSI439';
     	$Disciplina32->nome = 'GESTAO DA TECNOLOGIA DA INFORMACAO';
		$Disciplina32->name = 'INFORMATION TECHNOLOGY MANAGEMENT';
		$Disciplina32->chsemestral = '60';
		$Disciplina32->chsemanalt = '4';
		$Disciplina32->chsemanalp = '0';
     	$Disciplina32->departamento_id = '2';
		$Disciplina32->save();
		$Disciplina32->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina33 = new Disciplina();
     	$Disciplina33->codigo = 'ENP126';
     	$Disciplina33->nome = 'GERENCIA DE RECURSOS HUMANOS';
		$Disciplina33->name = 'MANAGEMENT OF HUMAN RESOURCES';
		$Disciplina33->chsemestral = '60';
		$Disciplina33->chsemanalt = '4';
		$Disciplina33->chsemanalp = '0';
     	$Disciplina33->departamento_id = '1';
		$Disciplina33->save();
		$Disciplina33->cursos()->sync('1', false);
		$Disciplina33->cursos()->sync('2', false);
		//<Producao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina34 = new Disciplina();
     	$Disciplina34->codigo = 'ENP493';
     	$Disciplina34->nome = 'EMPREENDEDORISMO';
		$Disciplina34->name = 'ENTREPRENEURSHIP';
		$Disciplina34->chsemestral = '60';
		$Disciplina34->chsemanalt = '4';
		$Disciplina34->chsemanalp = '0';
     	$Disciplina34->departamento_id = '1';
		$Disciplina34->save();
		$Disciplina34->cursos()->sync('2', false);
		$Disciplina34->cursos()->sync('4', false);
		//<Computacao/Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina35 = new Disciplina();
     	$Disciplina35->codigo = 'CSI462';
     	$Disciplina35->nome = 'SISTEMAS DE APOIO A DECISAO';
		$Disciplina35->name = 'DECISION SUPPORT SYSTEMS';
		$Disciplina35->chsemestral = '60';
		$Disciplina35->chsemanalt = '4';
		$Disciplina35->chsemanalp = '0';
     	$Disciplina35->departamento_id = '2';
		$Disciplina35->save();
		$Disciplina35->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>

     	$Disciplina36 = new Disciplina();
     	$Disciplina36->codigo = 'CSI463';
     	$Disciplina36->nome = 'SEGURANCA E AUDITORIA DE SISTEMAS';
		$Disciplina36->name = 'SECURITY AND SYSTEM AUDIT';
		$Disciplina36->chsemestral = '60';
		$Disciplina36->chsemanalt = '4';
		$Disciplina36->chsemanalp = '0';
     	$Disciplina36->departamento_id = '2';
		$Disciplina36->save();
		$Disciplina36->cursos()->sync('2', false);
		//<Sistemas>--------------------------------------------------------------------------<>
    }
}
