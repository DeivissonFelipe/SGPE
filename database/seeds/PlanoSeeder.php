<?php

use Illuminate\Database\Seeder;
use App\Plano;
use App\Turma;
use App\Exame;
use App\PlanejamentoAula;
use Carbon\Carbon;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        for($i = 1; $i < 15; $i++){
            //<------------------Turma---------------------------->        
            $turma = new Turma();
            $turma->id = $i;
            $rand = rand(1, 36);
            $turma->disciplina_id =  $rand;
            $turma->semestre_id = '1';
            $cursosDisciplina = \DB::table('disciplina_curso')->where('disciplina_id', '=', $rand)->pluck('curso_id')->toArray();
            $turma->curso_id = $cursosDisciplina[array_rand($cursosDisciplina, 1)];
            $turma->tipo_turma = '0';
            

		    $qtd = count($cursosDisciplina);
            sort($cursosDisciplina);		    
            $contador = 1;
            foreach ($cursosDisciplina as $c) {
                if($c == $turma->curso_id){
                    break;
                }
                else{
                    $contador++;
                }
            }		    
            $turma->numero_turma = $qtd . $contador;
            $turma->save();
            $turma->users()->sync(rand(6, 20), false); //linkando Professor
        
            //<------------------Plano----------------------------> 
            $plano = new Plano();
            $plano->id = $i;
            $plano->status = 'Aprovado';
            $plano->tipo = '1';
            $plano->turma_id = $turma->id;
            
            $plano->objetivo = '<p style="text-align: left;">Esta se&ccedil;&atilde;o apresenta o objetivo da disciplina.</p>';
            $plano->metodologia = '<p style="text-align: left;">Aqui ser&aacute; apresentado a metodologia utilizada pelo professor para realiza&ccedil;&atilde;o das aulas.&nbsp;</p>';
            $plano->avaliacao = '<p>A disciplina ser&aacute; avaliada atrav&eacute;s de provas, listas de exerc&iacute;cios, trabalhos pr&aacute;ticos.</p>';
            $plano->save();
            
            
            //<------------------Exames---------------------------->    
            $exame = new Exame();
            $exame->descricao ='Prova 1';
            $exame->peso ='20';
            $exame->data = Carbon::parse('2018-05-15');
            $exame->conteudo ='Todo o conteúdo da aula _ até a aula _';
            $exame->plano_id = $i;
            $exame->save();

            $exame = new Exame();
            $exame->descricao = 'Prova 2';
            $exame->peso ='30';
            $exame->data =Carbon::parse('2018-06-21');
            $exame->conteudo ='Todo o conteúdo da aula _ até a aula _';
            $exame->plano_id = $i;
            $exame->save();

            $exame = new Exame();
            $exame->descricao= 'Trabalho Prático';
            $exame->peso ='30';
            $exame->data =Carbon::parse('2018-07-03');
            $exame->conteudo ='Criação de um sistema ______';
            $exame->plano_id = $i;
            $exame->save();

            $exame = new Exame();
            $exame->descricao = 'Prova 3';
            $exame->peso ='20';
            $exame->data =Carbon::parse('2018-07-19');
            $exame->conteudo ='Todo o conteúdo da aula _ até a aula _';
            $exame->plano_id = $i;
            $exame->save();

            $exame = new Exame();
            $exame->descricao = 'Exame Especial';
            $exame->peso ='100';
            $exame->data =Carbon::parse('2018-07-20');
            $exame->conteudo ='Todo o conteúdo';
            $exame->plano_id = $i;
            $exame->save();
            
            //<------------------Planejamento---------------------------->    
            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '1';
            $planejamento->tipo = 'P';
            $planejamento->data =Carbon::parse('2018-03-12');
            $planejamento->conteudo = 'Conteudo da aula 1';
            $planejamento->plano_id = $i;
            $planejamento->save();
        
            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '2';
            $planejamento->tipo = 'T';
            $planejamento->data =Carbon::parse('2018-03-13');
            $planejamento->conteudo = 'Conteudo da aula 2';
            $planejamento->plano_id = $i;
            $planejamento->save();
            
            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '3';
            $planejamento->tipo = 'P';
            $planejamento->data =Carbon::parse('2018-03-14');
            $planejamento->conteudo = 'Conteudo da aula 3';
            $planejamento->plano_id = $i;
            $planejamento->save();

            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '4';
            $planejamento->tipo = 'P';
            $planejamento->data =Carbon::parse('2018-03-15');
            $planejamento->conteudo = 'Conteudo da aula 4';
            $planejamento->plano_id = $i;
            $planejamento->save();

            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '5';
            $planejamento->tipo = 'P';
            $planejamento->data =Carbon::parse('2018-03-16');
            $planejamento->conteudo = 'Conteudo da aula 5';
            $planejamento->plano_id = $i;
            $planejamento->save();

            $planejamento = new PlanejamentoAula();
            $planejamento->aula = '6';
            $planejamento->tipo = 'T';
            $planejamento->data =Carbon::parse('2018-03-17');
            $planejamento->conteudo = 'Conteudo da aula 6';
            $planejamento->plano_id = $i;
            $planejamento->save();
            

        }
        for($i = 1; $i <= 2; $i++){
            $plano = Plano::find($i);
            $plano->status = 'Em Análise';
            $plano->save();
        }
    }

}
