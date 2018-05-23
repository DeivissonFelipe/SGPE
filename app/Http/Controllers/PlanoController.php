<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\User;
use App\Disciplina;
use App\Curso;
use App\Semestre;
use App\Plano;
use App\Atendimento;
use App\Exame;
use App\Horario;
use App\PlanejamentoAula;
use App\PlanejamentoUnidade;
use App\Pendencia;
use PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;


class PlanoController extends Controller{
    public function index(){
		if(\Auth::check()){
			$user = User::find(auth()->id());
			$turmas_user = $user->turmas()->pluck('turma_id')->toArray();
			$planos_user = Plano::whereIn('turma_id', $turmas_user)
								->join('turmas', 'planos.turma_id', '=', 'turmas.id')
								->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
								->orderBy('disciplinas.nome', 'asc')
								->select('planos.*')
								->paginate(10);

			return view('planos.index')->with('planos', $planos_user);
		}else{
			$now = Carbon::now();
			$planos = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
				->where('semestres.inicio', '<=', $now)
				->where('semestres.fim', '>=', $now)
				->where('status', '=' , 'Aprovado')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->paginate(10);
			return view('planos.index_noAuth')->with('planos', $planos);
		}	
    }
	public function store(Request $request){
		$plano = Plano::create($request->all());
		$plano->tipo = 1;
		$plano->status = 'Em Edição';
		$plano->save();
		session()->flash('info', 'Plano de Ensino criado com sucesso!');
		return redirect('/planos');
	}
	public function show($id){
		try{
			$plano = Plano::findOrFail($id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}

		if(\Auth::check()){
			return view('planos.show')->with('plano', $plano);
		}else{
			return view('planos.show_noAuth')->with('plano', $plano);
		}
	}
	public function edit($id){
		try{
			$plano = Plano::findOrFail($id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}
		$pendencias = Pendencia::where('plano_id', $id)->get();
		return view('planos.edit')->with(compact('plano','pendencias'));
	}
	public function pdf(Request $request){
		try{
			$plano = Plano::findOrFail($request->id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}
		$pdf = PDF::loadView('planos.pdf', compact('plano'));
		return $pdf->stream('plano.pdf');
	}
	public function pdf2(Request $request){
		try{
			$plano = Plano::findOrFail($request->id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}
		return view('planos.pdf')->with('plano', $plano);
	}
	public function observacao(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->observacoes = $request->observacoes;
		$plano->save();
		session()->flash('info', 'Campo observações atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_planejamento($id){
		$plano = Plano::findOrFail($id);
		$semestre = $plano->turma()->first()->semestre()->first();
		$feriados = $semestre->feriados()->get();

		$diasNaoLetivos = array();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		$diasNaoLetivos = json_encode($diasNaoLetivos);
		return view('planos.partials-edit.planejamento')->with(compact('plano','semestre','diasNaoLetivos'));
	}
	public function index_ementa($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.ementa')->with('plano', $plano);		
	}
	public function ementa(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->ementa = $request->ementa;
		$plano->save();
		session()->flash('info', 'Campo ementa atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_conteudo($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.conteudo')->with('plano', $plano);
	}
	public function conteudo(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->conteudo = $request->conteudo;
		$plano->save();
		session()->flash('info', 'Campo conteudo atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_objetivo($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.objetivo')->with('plano', $plano);
	}
	public function objetivo(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->objetivo = $request->objetivo;
		$plano->save();
		session()->flash('info', 'Campo objetivo atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_avaliacao($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.avaliacao')->with('plano', $plano);
	}
	public function avaliacao(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->avaliacao = $request->avaliacao;
		$plano->save();
		session()->flash('info', 'Campo avaliacao atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_metodologia($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.metodologia')->with('plano', $plano);
	}
	public function metodologia(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->metodologia = $request->metodologia;
		$plano->save();
		session()->flash('info', 'Campo metodologia atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/edit')->with('plano', $plano);
	}
	public function index_bibliografia($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.bibliografia')->with('plano', $plano);
	}
	public function bibliografiab(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->bibliografiab = $request->bibliografiab;
		$plano->save();
		session()->flash('info', 'Campo bibliografia básica atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/bibliografias')->with('plano', $plano);
	}
	public function bibliografiac(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('owner', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->bibliografiac = $request->bibliografiac;
		$plano->save();
		session()->flash('info', 'Campo bibliografia complementar atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/bibliografias')->with('plano', $plano);
	}
	public function export($id){
		//Selecionando o plano a ser copiado
		$pOrign = Plano::findOrFail($id);
		//Recuperação de todos os planos de ensino que o usuário logado é responsável
		$user = User::find(auth()->id());
		$turmas_user = $user->turmas()->pluck('turma_id')->toArray();
		$planos_user = Plano::whereIn('turma_id', $turmas_user)
								->where('id', '!=' , $id)
								->get();

    	return view('planos.export')->with(compact('pOrign','planos_user'));
	}
	public function cpyPlano(Request $request){
		try{
			$pOrign = Plano::findOrFail($request->pOrign);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano a ser copiado não Encontrado!');
		}
		
		try{
			$pDestiny = Plano::findOrFail($request->pDestiny);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano destino não Encontrado!');
		}

		$this->authorize('owner', $pDestiny);
		
		DB::transaction(function () use($pOrign, $pDestiny){
			try{
				//Deletando dados de tabelas estrangeiras linkados ao plano antigo
				Atendimento::where('plano_id', $pDestiny->id)->delete();
				Exame::where('plano_id', $pDestiny->id)->delete();
				Horario::where('plano_id', $pDestiny->id)->delete();
				PlanejamentoAula::where('plano_id', $pDestiny->id)->delete();
				PlanejamentoUnidade::where('plano_id', $pDestiny->id)->delete();
			
				//Copiar campos da tabela "planos"
				$aux_plano = $pOrign->replicate();
				$aux_plano->exists = true;
				$aux_plano->id = $pDestiny->id;
				$aux_plano->turma_id = $pDestiny->turma_id;
				$aux_plano->aprovacao = null;
				$aux_plano->save();		

				//Recuperando do BD registros correspondente ao plano a ser copiado
				$atendimentos = Atendimento::where('plano_id', $pOrign->id)->get();
				$exames = Exame::where('plano_id', $pOrign->id)->get();
				$horarios = Horario::where('plano_id', $pOrign->id)->get();
				$planejamentoA = PlanejamentoAula::where('plano_id', $pOrign->id)->get();
				$planejamentoU = PlanejamentoUnidade::where('plano_id', $pOrign->id)->get();

				//Copiando os registros de tabelas estrangeiras e linkando ao plano de destino
				foreach ($atendimentos as $a ) {
					$aux_atendimento = $a->replicate();
					$aux_atendimento->plano_id = $pDestiny->id;
					$aux_atendimento->save();
				}
				foreach ($exames as $e ) {
					$aux_exame = $e->replicate();
					$aux_exame->plano_id = $pDestiny->id;
					$aux_exame->save();
				}
				foreach ($horarios as $h ) {
					$aux_horario = $h->replicate();
					$aux_horario->plano_id = $pDestiny->id;
					$aux_horario->save();
				}
				foreach ($planejamentoA as $planA ) {
					$aux_planA = $planA->replicate();
					$aux_planA->plano_id = $pDestiny->id;
					$aux_planA->save();
				}
				foreach ($planejamentoU as $planU ) {
					$aux_planU = $planU->replicate();
					$aux_planU->plano_id = $pDestiny->id;
					$aux_planU->save();
				}
				session()->flash('info', 'Exportação dos dados realizado com sucesso!');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Exportação do plano de ensino Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/planos');
	}
	public function category(){
		$id = Input::get('id');
		$array = array();
		switch ($id) {
			case '1':
				$subcategories = Disciplina::select('id','nome')->orderBy('nome', 'asc')->get();
				foreach ($subcategories as $key => $value) {
					$aux = ['id' => $value->id, 'nome' => $value->nome];
					array_push($array, $aux);
				}
			break;
			case '2':
				$subcategories = Disciplina::select('id', 'codigo')->get();
				foreach ($subcategories as $key => $value) {
					$aux = ['id' => $value->id, 'nome' => $value->codigo];
					array_push($array, $aux);
				}
			break;
			case '3':
				$subcategories = User::orderBy('name', 'asc')->get();
				foreach ($subcategories as $key => $value) {
					if($value->hasRole('Professor')){
						$aux = ['id' => $value->id, 'nome' => $value->name];
						array_push($array, $aux);
					}
				}
			break;
			case '4':
				$subcategories = Curso::select('id', 'nome')->orderBy('nome', 'asc')->get();
				foreach ($subcategories as $key => $value) {
					$aux = ['id' => $value->id, 'nome' => $value->nome];
					array_push($array, $aux);
				}
			break;
			case '5':
				$subcategories = Semestre::select('id', 'rotulo')->orderBy('inicio', 'desc')->get();
				foreach ($subcategories as $key => $value) {
					$aux = ['id' => $value->id, 'nome' => $value->rotulo];
					array_push($array, $aux);
				}
			break;
		}
		return Response::json($array);
	}
	public function buscar(Request $request){
		$idCategory = $request->category;
		$idSubCategory = $request->subcategory;
		$array = array();
		$now = Carbon::now();

		switch ($idCategory) {
			case '0':
				$user = User::find(auth()->id());
				$turmas_user = $user->turmas()->pluck('turma_id')->toArray();
				$resultados = Plano::whereIn('turma_id', $turmas_user)
								->join('turmas', 'planos.turma_id', '=', 'turmas.id')
								->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
								->orderBy('disciplinas.nome', 'asc')
								->select('planos.*')
								->get();
			break;
			case '1':
			case '2':
				$resultados = Plano::whereHas('turma', function($q) use ($idSubCategory)
				{
					$q->whereHas('disciplina', function($q) use ($idSubCategory)
					{
						$q->where('id', '=', $idSubCategory);
					});
				})
				->join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->where('semestres.inicio', '<=', $now)
				->where('semestres.fim', '>=', $now)
				->where('planos.status', '=' , 'Aprovado')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->get();
				
			break;
			case '3':
				$resultados = Plano::whereHas('turma', function($q) use ($idSubCategory)
				{
					$q->whereHas('users', function($q) use ($idSubCategory)
					{
						$q->where('users.id', '=', $idSubCategory);
					});
				})
				->join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->where('semestres.inicio', '<=', $now)
				->where('semestres.fim', '>=', $now)
				->where('planos.status', '=' , 'Aprovado')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->get();
			break;
			case '4':
				$resultados = Plano::whereHas('turma', function($q) use ($idSubCategory)
				{
					$q->whereHas('curso', function($q) use ($idSubCategory)
					{
						$q->where('curso_id', '=', $idSubCategory);
					});
				})
				->join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->where('semestres.inicio', '<=', $now)
				->where('semestres.fim', '>=', $now)
				->where('planos.status', '=' , 'Aprovado')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->get();
			break;
			case '5':
				$resultados = Plano::whereHas('turma', function($q) use ($idSubCategory)
				{
					$q->whereHas('semestre', function($q) use ($idSubCategory)
					{
						$q->where('semestre_id', '=', $idSubCategory);
					});
				})
				->where('planos.status', '=' , 'Aprovado')
				->join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->get();
			break;
		}

		$planos = Plano::hydrate( $resultados->toArray() );
		foreach ($planos as $key => $value) {
			$aux = [
				'id' => $value->id, 
				'nome' => $value->turma->disciplina->nome,
				'curso' => $value->turma->curso->nome,
				'turma' =>  $value->turma->numero_turma,
				'semestre' => $value->turma->semestre->rotulo
			];
			array_push($array, $aux);
		}
		return \Response::json($array);
	}
	public function planTipo(Request $request){
		$plano = Plano::findOrFail($request->id);
		$this->authorize('owner', $plano);
		$plano->tipo = $request->tipo;
		$plano->save();
		return;
	}
	public function warnings($id){
		$warning = [];
		$peso_aval = false;
		$plano = Plano::find($id);
		//====================================================================>
		// -Definir avaliação com peso maior do que 50%; 
		$exames = $plano->exames()->get();
		foreach ($exames as $key => $value) {
			if($value->peso > 50){
				$peso_aval = true;
			}
		}

		if($peso_aval){
			$warning += [
				'peso_50'=>'Uma avaliação está com peso maior do que 50pts. É necessário possuir autorização prévia do colegiado do curso correspondente!',
			];
		}
		//====================================================================>
		// -Planejamento não apresenta o total de horas requerido pela disciplina
		if($plano->tipo == 1){
			$planejamento_aula = $plano->planejamentoAulas()->get();
			$soma = 0;

			$qtd = count($planejamento_aula);
			$horas = ($qtd * 100) /60;
			
			if($horas < $plano->turma()->first()->disciplina()->first()->chsemestral){
				$warning += [
					'planejamento_hora'=> 'A quantidade de hora registrada no planejamento não corresponde ao total recomendado pela disciplina.',
				];	
			}
			
		}else{
			$planejamento_unid = $plano->planejamentoUnidades()->get();
			$horas = 0;
			foreach ($planejamento_unid as $p_unid) {
				$horas+= $p_unid->hora_aula;
			}
			if($horas < $plano->turma()->first()->disciplina()->first()->chsemestral){
				$warning += [
					'planejamento_hora'=> 'A quantidade de hora registrada no planejamento não corresponde ao total recomendado pela disciplina.',
				];
			}
		}

		return \Response::json($warning);
	}
	public function verificacao($id){
		$plano = Plano::find($id);
		$error = [];
		$this->authorize('owner', $plano);

		if($plano->status == "Em Edição"){
			//====================================================================>
			// Conferir se a disciplina está sendo ofertada para o curso em questão

				$turma_valid = \DB::table('disciplina_curso')
								->where('disciplina_id', '=', $plano->turma()->first()->disciplina_id)
								->where('curso_id', '=', $plano->turma()->first()->curso_id)
								->select('disciplina_curso.*')
								->first();
								
				if(!isset($turma_valid)){
					$error += [
						'disciplina_nOfertada'=> 'A disciplina selecionada não é ofertada pelo curso escolhido. Verifique e atualize os dados da turma correspondente à este plano de ensino.',
					];
				}

			//====================================================================>
			// -Somatório de pesos de avaliação não corresponde a 100%;

			$exames = $plano->exames()->get();
			$soma = 0;
			foreach ($exames as $key => $value) {
				$soma += $value->peso;
			}

			if($soma < 100){
				$error += [
					'soma_menor100'=> 'A pontuação total de avaliação se encontra com peso menor do que 100pts.',
				];
			}
			//====================================================================>
			// -Não informar horário de atendimento, 
			// -informar horario de atendimento de duração menor do que 2 horas; 

			// $atendimentos = $plano->atendimentos()->get();
			// $total_hora = 0;
			// $total_minuto = 0;
			// foreach($atendimentos as $key => $value){
			// 	$horario_inicio = explode(':', $value->inicio);
			// 	$hora_inicio = $horario_inicio[0];
			// 	$minuto_inicio = $horario_inicio[1];

			// 	$horario_fim = explode(':', $value->fim);
			// 	$hora_fim = $horario_fim[0];
			// 	$minuto_fim = $horario_inicio[1];

			// 	$total_hora += $hora_fim - $hora_inicio;
			// 	$total_minuto += $minuto_fim - $minuto_inicio;
			// }

			// if($total_hora < 2){
			// 	$hora_minuto = $total_minuto % 60;
			// 	$total = $hora_minuto + $total_hora;
			// 	if($total < 2){
			// 		$error += [
			// 			'atendimento_menor2'=> 'O horário de atendimento por semana está  com uma quantidade baixa. Recomenda-se que sejam disponibilizados ao menos 2 horas de atendimento por disciplina.',
			// 		];
			// 	} 
			// }


			//====================================================================>
			// -Substituição
			$horarios = $plano->atendimentos()->get();
			$dias = $this->parseDayForNumber($horarios->pluck('dia'));
			$turma = $plano->turma()->first();
			$trocas = $turma->semestre()->first()->trocas()->get();

			// Exames
			foreach($trocas as $key => $value){
				$data_troca = date("Y-m-d", strtotime($value->dia));
				$exame = \DB::table('exames')
								->where('plano_id', '=', $plano->id)
								->where('data', '=', $data_troca)
								->select('exames.*')
								->first();
				if(isset($exame)){
					$e_carbon = Carbon::createFromFormat('Y-m-d', $exame->data);
					$e_dia = $e_carbon->dayOfWeek;
					if(!in_array($e_dia, $dias)){
						$error += [
							'exame_substituicao'=> 'Uma avaliação está sendo marcada para um dia de substituição letivo. O dia da semana em questão não é um dia selecionado na seção horário de aula.',
						];
					}
				}							
			}	
			
			
			// 	Planejamento Aula
			if($plano->tipo == 1){
				foreach($trocas as $key => $value){
					$data_troca = date("Y-m-d", strtotime($value->dia));
					$planejamento = \DB::table('planejamento_aulas')
									->where('plano_id', '=', $plano->id)
									->where('data', '=', $data_troca)
									->select('planejamento_aulas.*')
									->first();
					if(isset($planejamento)){
						$p_carbon = Carbon::createFromFormat('Y-m-d', $planejamento->data);
						$p_dia = $p_carbon->dayOfWeek;
						if(!in_array($p_dia, $dias)){
							$error += [
								'planejamento_substituicao'=> 'Uma aula está sendo marcada em um dia de substituição letiva. O dia da semana em questão não é um dia selecionado na seção horário de aula.',
							];
						}
					}	
				}	
			}	
			//====================================================================>

			if($plano->tipo == 1){
				$planejamento_aula = $plano->planejamentoAulas()->get();
				if($planejamento_aula->isEmpty()){
					$error += [
						'planejamento_empty'=> 'Não há registro salvo na seção de planejamento.',
					];
				}
			}else{
				$planejamento_unid = $plano->planejamentoUnidades()->get();
				if($planejamento_unid->isEmpty()){
					$error += [
						'planejamento_empty'=> 'Não há registro salvo na seção de planejamento.',
					];
				}
			}

			//====================================================================>

			
			$horarios = $plano->atendimentos()->get();
			if($horarios->isEmpty()){
				$error += [
					'horario_empty'=> 'Não há registro salvo na seção de horários de aula.',
				];			
			}
			
			$bibb = $plano->bibliografiab;
			$bibc = $plano->bibliografiac;
			if(!isset($bibb)){
				$error += [
					'bibliografiab_empty'=> 'Não há informação salva na seção de bibliografia básica.',
				];			
			}
			if(!isset($bibc)){
				$error += [
					'bibliografiab_empty'=> 'Não há informação salva na seção de bibliografia complementar.',
				];			
			}

			$ementa = $plano->ementa;
			if(!isset($ementa)){
				$error += [
					'ementa_empty'=> 'Não há informação salva na seção de ementa.',
				];			
			}
			$metodologia = $plano->metodologia;
			if(!isset($metodologia)){
				$error += [
					'metodologia_empty'=> 'Não há informação salva na seção de ementa.',
				];			
			}
			$conteudo = $plano->conteudo;
			if(!isset($conteudo)){	
				$error += [
					'conteudo_empty'=> 'Não há informação salva na seção de conteudo.',
				];			
			}
			$objetivo = $plano->objetivo;
			if(!isset($objetivo)){
				$error += [
					'objetivo_empty'=> 'Não há informação salva na seção de objetivo.',
				];			
			}	

			$errorCount  = count($error);
			if($errorCount == 0){
				$plano->status = "Em Análise";
				session()->flash('info', 'O Plano de Ensino foi enviado ao departamento resposável para análise e aprovação!');
				return redirect()->action('PlanoController@index');
			}else{
				return back()->withErrors($error);
			}
		}
		else{
			return back()->with('warnings', 'Este plano de ensino já se encontra em análise, ou já foi aprovado pela assembléia!');
		}
	}
	public function parseDayForNumber($dias){
		$array = array();
		foreach ($dias as $key => $value) {
			switch ($value) {
				case 'Segunda-Feira':
					array_push($array, 1);
				break;
				case 'Terça-Feira':
					array_push($array, 2);
				break;
				case 'Quarta-Feira': 
					array_push($array, 3);
				break;
				case 'Quinta-Feira':
					array_push($array, 4);
				break;
				case 'Sexta-Feira':
					array_push($array, 5);
				break;
			}
		}
		return $array;
	}
	public function aprovacao(){
		$now = Carbon::now();
		$resultados = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
			->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
			->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
			->where('semestres.inicio', '<=', $now)
			->where('semestres.fim', '>=', $now)
			->where('planos.status', '=', 'Em Análise')
			->orderBy('disciplinas.nome', 'asc')
			->select('planos.*')
			->paginate(10);

		$array = array();
		$semestres = Semestre::select('id', 'rotulo')->get();
		foreach ($semestres as $key => $value) {
			$aux = ['id' => $value->id, 'nome' => $value->rotulo];
			array_push($array, $aux);
		}

		$planos = $resultados;
		return view('planos.aprovacao')->with(compact('planos', 'array'));
	}
	public function aprovacaoSemestre(Request $request){
		$resultados = \DB::table('planos')
			->join('turmas', 'planos.turma_id', '=', 'turmas.id')
			->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
			->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
			->where('semestres.id', '=', $request->semestre)
			->where('planos.status', '=', 'Em Análise')
			->orderBy('disciplinas.nome', 'asc')
			->select('planos.*')
			->get();

		$array = array();
		$planos = Plano::hydrate( $resultados->toArray() );
		foreach ($planos as $key => $value) {
			$aux = [
				'id' => $value->id, 
				'nome' => $value->turma->disciplina->nome,
				'curso' => $value->turma->curso->nome,
				'turma' =>  $value->turma->numero_turma,
				'semestre' => $value->turma->semestre->rotulo
			];
			array_push($array, $aux);
		}
		return \Response::json($array);
	}
	public function aprovar($id){
		$plano = Plano::findOrFail($id);
		$plano->aprovacao = Carbon::now();
		$plano->status = "Aprovado";
		$plano->save();
		return json_encode(array("success" => "true", 'msg' => 'O Plano de Ensino foi Aprovado com sucesso!'));
	}
	public function pendencia($id){
		$plano = Plano::findOrFail($id);
		$pendencias = Pendencia::where('plano_id', $id)->get();
		return view('planos.reg_pend')->with(compact('plano', 'pendencias'));
	}
	public function registrarPendencia(Request $request){
		DB::transaction(function() use($request){
			try{
				$pendencia = Pendencia::create($request->all());
				$pendencia->save();
				$plano = Plano::find($request->plano_id);
				$plano->status = 'Em Edição';
				$plano->save();
				session()->flash('info', 'Pendência criada com sucesso! O Plano de Ensino foi retornado ao professor responsável !');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Registro da pendência Falhou. ' . $e->getMessage());
			}
		});		
		return redirect()->action('PlanoController@aprovacao');
	}
	public function view_pend($id){
		$plano = Plano::findOrFail($id);
		$pendencias = Pendencia::where('plano_id', $id)->get();
		return view('planos.view_pend')->with(compact('plano', 'pendencias'));
	}
	public function search(Request $request){
		$busca = $request->busca;
		$now = Carbon::now();
		$planos = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
			->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
			->join('cursos', 'cursos.id', '=', 'turmas.curso_id')
			->join('disciplinas', 'disciplinas.id', '=', 'turmas.disciplina_id')
			->join('user_turma', 'user_turma.turma_id', '=', 'turmas.id')
			->join('users', 'users.id', '=', 'user_turma.user_id')
			->where('semestres.inicio', '<=', $now)
			->where('semestres.fim', '>=', $now)
			->where('status', '=' , 'Aprovado')
			->where(function ($query) use ($busca) {
				$query->where('cursos.nome', 'LIKE', '%'.$busca.'%')
					->orWhere('disciplinas.name', 'LIKE', '%'.$busca.'%')
					->orWhere('disciplinas.nome', 'LIKE', '%'.$busca.'%')
					->orWhere('disciplinas.codigo', 'LIKE', '%'.$busca.'%')
					->orWhere('users.name', 'LIKE', '%'.$busca.'%');
			})
			->orderBy('disciplinas.nome', 'asc')
			->select('planos.*')
			->paginate(10);
		
		return view('planos.index_noAuth')->with('planos', $planos);
	}
}






