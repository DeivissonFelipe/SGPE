<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Disciplina;
use App\Curso;
use App\Semestre;
use App\User;
use App\Plano;
use App\Turma;
use App\Exame;
use App\Horario;
use App\PlanejamentoAula;
use App\PlanejamentoUnidade;
use App\Pendencia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PlanoRequest;

class PlanoController extends Controller{
	/**
	 * Renderiza a página de index dos planos de ensino.
	 */
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

	/**
	 * Busca todos os planos relacionados ao campo de busca ['index']
	 * @param Request $request - Requisição HTTP, com o campo de busca
	 */
	public function search(Request $request){
		$busca = $request->busca;
		$now = Carbon::now();

		if($busca == ""){
			$planos = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
				->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
				->where('semestres.inicio', '<=', $now)
				->where('semestres.fim', '>=', $now)
				->where('status', '=' , 'Aprovado')
				->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
				->orderBy('disciplinas.nome', 'asc')
				->select('planos.*')
				->paginate(10);
		}else{
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
			$planos->appends($request->only('busca'));
		}

		return view('planos.index_noAuth', compact('planos'));
	}

	/**
	 * Renderiza a página de index da seção 'planos em geral'
	 */
	public function index_geral(){
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
		return view('planos.index_geral')->with('planos', $planos);
	}

	/**
	 * Busca todos os planos relacionados ao campo de busca ['planos em geral']
	 * @param Request $request - Requisição HTTP, com o campo de busca
	 */
	public function search_geral(Request $request){
		$busca = $request->busca;
		$now = Carbon::now();

		if($busca == ""){
			$planos = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
			->join('semestres', 'semestres.id', '=', 'turmas.semestre_id')
			->where('semestres.inicio', '<=', $now)
			->where('semestres.fim', '>=', $now)
			->where('status', '=' , 'Aprovado')
			->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
			->orderBy('disciplinas.nome', 'asc')
			->select('planos.*')
			->paginate(10);
		}else{
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
			$planos->appends($request->only('busca'));
		}
		return view('planos.index_geral')->with('planos', $planos);
	}

	/**
	 * Renderiza a página de visualização do plano de ensino selecionado
	 * @param int $id - identificador do plano de ensino selecionado
	 */
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

	/**
	 * Renderiza a página de menu de edição do plano selecionado
	 * @param int $id - identificador do plano de ensino selecionado
	 */
	public function edit_dados($id){
		try{
			$plano = Plano::findOrFail($id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}
		$this->authorize('update', $plano);
		return view('planos.edit_dados')->with(compact('plano'));
	}

	/**
	 * Renderiza a página de registro dos planos
	 */
	public function create(){
		$allUsers = User::all();
    	$users = array();
		
    	foreach ($allUsers as $u) {
    		if($u->hasRole('Professor')){
				array_push($users, $u);
    		}
    	}
		
		$disciplinas = Disciplina::where('ementa','!=',null)
			->where('conteudo','!=',null)
			->where('bibliografiab','!=',null)
			->where('bibliografiac','!=',null)
			->orderBy('nome', 'asc')
			->get();

    	$semestres = Semestre::orderBy('inicio','desc')->get();
    	$cursos = Curso::orderBy('nome', 'asc')->get();
    	return view('planos.create')->with(compact('users','disciplinas','semestres','cursos'));
	}

	/**
	 * Registra um plano no banco de dados.
	 * @param PlanoRequest $request - Requisição HTTP com campos validados.
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function store(PlanoRequest $request){
		$users = $request->user_id;
		
		if(!in_array(auth()->id(), $users)){
			return back()->withErrors('A criação do plano falhou! Seu nome não está incluso como professor da turma.');
		}
		
		$turma = new Turma;
		$turma->disciplina_id = $request->disciplina_id;
		$turma->semestre_id = $request->semestre_id;
		$turma->curso_id = $request->curso_id;
		if($request['tipo_turma']){
			$turma->tipo_turma = 1; //Criação/Update de turma 'Extra'
		}else{ 
			$turma->tipo_turma = 0; //Criação/Update de turma 'Padrão'
		}

		DB::transaction(function () use($turma, $request){
			try{
				$turma->save();
				// Adiciona uma relação na tabela 'user_turma' entre a turma em questão e os usuários passados pela requisição via post. 
				// Uma vez que o método somente adiciona novos registros, um segundo parâmetro é necessário para não apagar os registros anteriormente salvos na tabela.
				$turma->users()->sync($request->user_id, false);
				$this->setNumeroTurma($turma);

				foreach ($request->horario as $h) {
					$horario = new Horario;
					$horario->turma_id = $turma->id;
					$horario->dia = $h;
					$horario->save();
				}

				$plano = new Plano();
				$plano->turma_id = $turma->id;
				$plano->tipo = 1; //plano por aula [1], plano por unidade [2]
				$plano->status = 'Em Edição';
				$plano->save();
				
				//chamar metodo para preencher planejamento do plano
				$this->preencher_planejamento($turma->id);

				session()->flash('info', 'Plano de ensino criado com sucesso!');
			}catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Criação do plano Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/planos');
	}

	/**
	 * Renderiza a página de atualização[configurar] do plano selecionado
	 * @param int $id - identificador do plano selecionado
	 */
	public function edit($id){
		$plano = Plano::find($id);
		$this->authorize('update', $plano);
		$turma = $plano->turma()->first();
		$allUsers = User::all();
    	$users = array();

    	foreach ($allUsers as $u) {
    		if($u->hasRole('Professor')){
    			array_push($users, $u);
    		}
    	}
		
    	$disciplinas = Disciplina::orderBy('nome', 'asc')->get();
    	$semestres = Semestre::orderBy('inicio','desc')->get();
    	$cursos = Curso::orderBy('nome', 'asc')->get();
		$horarios = Horario::where('turma_id', '=', $turma->id)->pluck('dia');
	
		$h_array = array();
		foreach($horarios as $h){
			$h_array[] =  $h;
		}
		return view('planos.edit')->with(compact('users','disciplinas', 'semestres', 'cursos', 'plano', 'turma', 'h_array'));
	}

	/**
	 * Atualiza o registro do plano no banco de dados
	 * @param PlanoRequest $request - Requisição HTTP com campos validados
	 * @param int $id - identificador do plano selecionado
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function update(PlanoRequest $request, $id){
		$plano = Plano::findOrFail($id);
		$turma = $plano->turma()->first();
		$this->authorize('update', $plano);

		$turma->disciplina_id = $request->disciplina_id;
		$turma->semestre_id = $request->semestre_id;
		$turma->curso_id = $request->curso_id;
		if($request['tipo_turma']){
			$turma->tipo_turma = 1; //Criação/Update de turma 'Extra'
		}else{
			$turma->tipo_turma = 0; //Criação/Update de turma 'Padrão'
		}
		
		DB::transaction(function () use($turma, $request, $plano){
			try{
				$turma->save();
				//Se o campo professor tiver enviado ids pela requisição post para realizar o update...
				if(isset($request->user_id)){
					//... então o método sync apaga todas as incidências de usuários para a turma em questão
					// e cria novas incidências com os valores que foram passados pelo request 
					// na tabela 'user_turma'	
					$turma->users()->sync($request->user_id);
				}else{
					//... caso contrário ele apaga todas as incidências de usuários para a turma em questão
					$turma->users()->sync(array());
				}
				$this->setNumeroTurma($turma);

				$turma->horarios()->delete();
				foreach ($request->horario as $h) {
					$horario = new Horario;
					$horario->turma_id = $turma->id;
					$horario->dia = $h;
					$horario->save();
				}
				
				//-------------------------------------------------------------------------------------------->
				//recuperar os planejamentos do plano pre alteração
				$planAula1 = $plano->planejamentoAulas()->get();
			
				//deletar os planejamentos antigos
				$plano->planejamentoAulas()->delete();

				//chamar metodo para preencher planejamento do plano
				$this->preencher_planejamento($turma->id);

				//recuperar os planejamentos do planos pos alteração
				$planAula2 = $plano->planejamentoAulas()->get();

				if($planAula1->count() > $planAula2->count()){ //se qtd de planejamento antigo > novo
					//recopiar o conteudo do planejamento
					for($i=0; $i < $planAula1->count(); $i++){
						if(isset($planAula2[$i])){
							$planAula2[$i]->tipo = $planAula1[$i]->tipo;
							$planAula2[$i]->conteudo = $planAula1[$i]->conteudo;
							$planAula2[$i]->save();
						}else{
							$planA = new PlanejamentoAula;
							$planA->aula = $i+1;
							$planA->tipo = $planAula1[$i]->tipo;
							$planA->conteudo = $planAula1[$i]->conteudo;
							$planA->plano_id = $plano->id;

							$planA->save();
						}
					}
				}
				else{ //se qtd de planejamento novo >= antigo
					//recopiar o conteudo do planejamento
					for($i = 0 ; $i < $planAula2->count(); $i++){
						if(isset($planAula1[$i])){
							$planAula2[$i]->tipo = $planAula1[$i]->tipo;
							$planAula2[$i]->conteudo = $planAula1[$i]->conteudo;
							$planAula2[$i]->save();
						}
					}
				}			
				//-------------------------------------------------------------------------------------------->
				session()->flash('info', 'Plano atualizado com sucesso!');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Atualização do plano Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/planos');
	}

	/**
	 * Configura o número da turma selecionada.
	 * @param \App\Turma $turma - instância da turma selecionada
	 */
	public function setNumeroTurma($turma){
		$disciplina_id = $turma->disciplina->id;
		$curso = $turma->curso->sigla;
		switch ($curso) {
			case 'EP':
				$nCurso = 1;
			break;
			case 'SI':
				$nCurso = 2;
			break;
			case 'EE':
				$nCurso = 3;
			break;
			case 'EC':
				$nCurso = 4;
			break;
		}

		$result = \DB::table('disciplina_curso')
					->where('disciplina_id', '=', $disciplina_id)
					->pluck('curso_id');
		
		$result = $result->toArray();

		//1ºnumero (qtd de registro)
		$qtd = count($result);
		
		//2º numero 
		//array ordenado
		sort($result);
		$contador = 1;
		foreach ($result as $r) {
			if($r == $nCurso){
				break;
			}
			else{
				$contador++;
			}
		}
		
		// numero turma = nº1 concatenado com nº2
		$numeroTurma = $qtd . $contador;
		$turma->numero_turma = $numeroTurma;
		$turma->save();	
	}

	/**
	 * Preenche a tabela 'planejamento_aulas' de acordo com os dias letivos configurados para o plano
	 * @param int $id - identificador do plano selecionado
	 */
	public function preencher_planejamento($id){
		$turma = Turma::findOrFail($id);
		$semestre = $turma->semestre()->first();
		$horarios = $turma->horarios()->get();
		$feriados = $semestre->feriados()->get();
		$trocas = $semestre->trocas()->get();

		$dias_trocas = array();
		foreach($trocas as $key => $t){
			array_push($dias_trocas, $t->dia);
		}

		$dias_nletivos = array();
		foreach($feriados as $key => $f){
			array_push($dias_nletivos, $f->data);
		}

		$dias_numero = array();
		foreach ($horarios as $key => $h) {
			array_push($dias_numero, $h->dia);
		}

		$cont=1;
		$period = CarbonPeriod::since($semestre->inicio)->until($semestre->fim);
		foreach ($period as $key => $date) {
			$dia_semana = date('w', strtotime($date));
			if(in_array($date->format('d-m-Y'), $dias_trocas)){
				$num_troca = \App\Troca::getSub_Number($date->format('Y-m-d'));
				if(in_array($num_troca, $dias_numero)){
					$planA = new PlanejamentoAula;
					$planA->aula = $cont++;
					$planA->tipo = 'T';
					$planA->data = $date;
					$planA->plano_id = $turma->planos()->first()->id;
					$planA->save();
				}
			}else{
				if(in_array($dia_semana, $dias_numero) && !in_array($date->format('d-m-Y'), $dias_nletivos)){
					$planA = new PlanejamentoAula;
					$planA->aula = $cont++;
					$planA->tipo = 'T';
					$planA->data = $date;
					$planA->plano_id = $turma->planos()->first()->id;
					$planA->save();
				}
			}
		}
	}

	/**
	 * Renderiza a página de visualização do plano [Expandido, sem template]
	 * @param int $id - identificador do plano selecionado
	 */
	public function expandir($id){
		try{
			$plano = Plano::findOrFail($id);
		}catch(ModelNotFoundException $exception){
			return back()->withError('Plano ' .$id. ' não Encontrado!');
		}
		return view('planos.expandido')->with('plano', $plano);
	}
	
	/**
	 * Registra o campo observação no plano selecionado
	 * @param Request $request - Requisição HTTP
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de exames
	 */
	public function observacao(Request $request){
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('update', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->observacoes = $request->observacoes;
		$plano->save();
		session()->flash('info', 'Campo observações atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/exames')->with('plano', $plano);
	}

	/**
	 * Renderiza a página index dos planejamentos, do plano de ensino selecionado
	 * @param int $id - identificador do plano selecionado
	 */
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

	/**
	 * Renderiza a página de edição do objetivo, do plano selecionado
	 * @param int $id - identificador do plano selecionado
	 */
	public function index_objetivo($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.objetivo')->with('plano', $plano);
	}

	/**
	 * Salva o campo objetivo no registro do plano selecionado
	 * @param Request $request - Requisição HTTP
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de edição do objetivo
	 */
	public function objetivo(Request $request){
		if($request->objetivo == ""){
			return back()->withError('Este campo não deve ser nulo!');	
		}
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('update', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->objetivo = $request->objetivo;
		$plano->save();
		session()->flash('info', 'Campo objetivo atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/objetivos')->with('plano', $plano);
	}

	/**
	 * Renderiza a página de edição da atividade avaliativa, do plano selecionado
	 * @param int $id - identificador do plano selecionado
	 */
	public function index_avaliacao($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.avaliacao')->with('plano', $plano);
	}

	/**
	 * Salva o campo avaliacao no registro do plano selecionado
	 * @param Request $request - Requisição HTTP
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de edição do avaliacao
	 */
	public function avaliacao(Request $request){
		if($request->avaliacao == ""){
			return back()->withError('Este campo não deve ser nulo!');	
		}
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('update', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->avaliacao = $request->avaliacao;
		$plano->save();
		session()->flash('info', 'Campo avaliacao atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/avaliacoes')->with('plano', $plano);
	}

	/**
	 * Renderiza a página de edição da metodologia, do plano selecionado
	 * @param int $id - identificador do plano selecionado
	 */
	public function index_metodologia($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.metodologia')->with('plano', $plano);
	}

	/**
	 * Salva o campo metodologia no registro do plano selecionado
	 * @param Request $request - Requisição HTTP
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de edição do metodologia
	 */
	public function metodologia(Request $request){
		if($request->metodologia == ""){
			return back()->withError('Este campo não deve ser nulo!');	
		}
		$plano = Plano::findOrFail($request->plano_id);
		$this->authorize('update', $plano);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$plano->metodologia = $request->metodologia;
		$plano->save();
		session()->flash('info', 'Campo metodologia atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/metodologias')->with('plano', $plano);
	}

	/**
	 * Renderiza a página de exportação do plano
	 * @param int $id - identificador do plano a ser copiado
	 */
	public function export($id){
		//Selecionando o plano a ser copiado
		$pOrign = Plano::findOrFail($id);
		//Recuperação de todos os planos de ensino que o usuário logado é responsável
		$user = User::find(auth()->id());
		$turmas_user = $user->turmas()->pluck('turma_id')->toArray();
		if(count($turmas_user) <= 0){
			return back()->withError('Nenhum plano de ensino encontrado! Para exportar este plano de ensino é necessário possuir ao menos um plano para realização da cópia.');	
		}
		$planos_user = Plano::whereIn('turma_id', $turmas_user)
								->where('id', '!=' , $id)
								->where('status', '!=', 'Aprovado')
								->get();

    	return view('planos.export')->with(compact('pOrign','planos_user'));
	}

	/**
	 * Copia os dados [editáveis] do plano de 'origem' (plano que foi acessado e selecionado o menu de exportação)
	 * para o plano 'destino' (plano do usuário [professor] logado).
	 * @param Request $request - Requisição HTTP
	 */
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

		$this->authorize('update', $pDestiny);
	
		DB::transaction(function () use($pOrign, $pDestiny){
			try{
				//Deletando dados de tabelas estrangeiras linkadas ao plano antigo
				Exame::where('plano_id', $pDestiny->id)->delete();
				PlanejamentoAula::where('plano_id', $pDestiny->id)->delete();
				PlanejamentoUnidade::where('plano_id', $pDestiny->id)->delete();
			
				//Copiar campos da tabela "planos"
				$aux_plano = $pOrign->replicate();
				$aux_plano->exists = true;
				$aux_plano->id = $pDestiny->id;
				$aux_plano->turma_id = $pDestiny->turma_id;
				$aux_plano->status = "Em Edição";
				$aux_plano->aprovacao = null;
				$aux_plano->save();		

				//Recuperando do BD registros correspondente ao plano a ser copiado
				$exames = Exame::where('plano_id', $pOrign->id)->get();
				$planAula1 = PlanejamentoAula::where('plano_id', $pOrign->id)->get();
				$planejamentoU = PlanejamentoUnidade::where('plano_id', $pOrign->id)->get();

				//Copiando os registros de tabelas estrangeiras e linkando ao plano de destino
				
			
				//Planejamento Aula
				//-------------------------------------------------------------------------------------------->
				//chamar metodo para preencher planejamento do plano
				$this->preencher_planejamento($pDestiny->turma()->first()->id);

				$planAula2 = PlanejamentoAula::where('plano_id', $pDestiny->id)->get();
			
				if($planAula1->count() > $planAula2->count()){ //se qtd de planejamento pOrign > pDestiny
					for($i=0; $i < $planAula1->count(); $i++){
						if(isset($planAula2[$i])){
							$planAula2[$i]->tipo = $planAula1[$i]->tipo;
							$planAula2[$i]->conteudo = $planAula1[$i]->conteudo;
							$planAula2[$i]->save();
						}else{
							$aux_planA = new PlanejamentoAula;
							$aux_planA->aula = $i+1;
							$aux_planA->tipo = $planAula1[$i]->tipo;
							$aux_planA->conteudo = $planAula1[$i]->conteudo;
							$aux_planA->plano_id = $pDestiny->id;
							$aux_planA->save();
						}
					}
				}
				else{ //se qtd de planejamento pDestiny >= pOrign	
					for($i = 0 ; $i < $planAula2->count(); $i++){
						if(isset($planAula1[$i])){
							$planAula2[$i]->tipo = $planAula1[$i]->tipo;
							$planAula2[$i]->conteudo = $planAula1[$i]->conteudo;
							$planAula2[$i]->save();
						}
					}
				}
				//-------------------------------------------------------------------------------------------->

				foreach ($planejamentoU as $planU ) {
					$aux_planU = $planU->replicate();
					$aux_planU->plano_id = $pDestiny->id;
					$aux_planU->save();
				}

				foreach ($exames as $e ) {
					$aux_exame = $e->replicate();
					$aux_exame->data = null;
					$aux_exame->plano_id = $pDestiny->id;
					$aux_exame->save();
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
	
	/**
	 * Verifica e retorna notificação ao usuário [professor] com as pendências não obrigatórias
	 * 
	 * Caso haja pendências um modal dará a opção ao usuário de continuar o envio
	 * do plano para análise, ou cancelar o envio e editar as pendências.
	 * 
	 * @param int $id - identificador do plano a ser copiado
	 */
	public function warnings($id){
		$warning = [];
		$peso_aval = false;
		$plano = Plano::findOrFail($id);
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
		// - Planejamento não apresenta o total de horas requerido pela disciplina
		if($plano->tipo == 1){ //Planejamento por Aula
			$planejamento_aula = $plano->planejamentoAulas()->get();
			$soma = 0;

			$qtd = count($planejamento_aula);
			$horas = ($qtd * 100) /60;
			
			if($horas < $plano->turma()->first()->disciplina()->first()->chsemestral){
				$warning += [
					'planejamento_hora'=> 'A quantidade de hora registrada no planejamento não corresponde ao total recomendado pela disciplina.',
				];	
			}
			
		}else{ // Planejamento por Unidade
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

	/**
	 * Verifica e valida os campos editáveis do plano de ensino.
	 * 
	 * Caso haja pendências uma notificação será retornada ao usuário [professor] responsável.
	 * Se todas as validações forem aceitas, o campo de status será alterado para 'Em Análise'
	 * [Envia o plano para análise de aprovação]
	 * 
	 * @param int $id - identificador do plano a ser copiado
	 */
	public function verificacao($id){
		// - Configurando variaveis necessárias
		//------------------------------------------------------------------------>
		$plano = Plano::find($id);
		$this->authorize('owner', $plano);
		$turma = $plano->turma()->first();
		$exames = $plano->exames()->get();
		$planAula = $plano->planejamentoAulas()->orderBy('data', 'asc')->get();
		$planUnid = $plano->planejamentoUnidades()->get();
		$horarios = $turma->horarios()->get();
		$diasL_semana = array(); // dia de semana letivo para turma
		foreach ($horarios as $key => $h) {
			array_push($diasL_semana, $h->dia);
		}
		$trocas = $turma->semestre()->first()->trocas()->get();
		$dias_troca = array(); // dias que ocorrem uma substituição de dia letivo
		foreach($trocas as $key => $t){
			array_push($dias_troca, $t->dia);
		}
		$error = [];
		//------------------------------------------------------------------------>


		if($plano->status == "Em Edição"){
			//====================================================================>
			//OBJETIVO
				// - Confere se existe informação salva na seção de objetivos
				$objetivo = $plano->objetivo;
				if(!isset($objetivo)){
					$error += [
						'objetivo_empty'=> 'Não há informação salva na seção de Objetivos.',
					];			
				}	
			//====================================================================>
			//METODOLOGIA
				// - Confere se existe informação salva na seção de metodologias
				$metodologia = $plano->metodologia;
				if(!isset($metodologia)){
					$error += [
						'metodologia_empty'=> 'Não há informação salva na seção de Metodologia.',
					];			
				}	
			//====================================================================>
			//AVALIAÇÂO
				// - Confere se existe informação salva na seção de atividades avaliativas
				$avaliacao = $plano->avaliacao;
				if(!isset($avaliacao)){
					$error += [
						'avaliacao_empty'=> 'Não há informação salva na seção de Atividades Avaliativas.',
					];			
				}	
			//====================================================================>
			//EXAMES
				// - Somatório de pesos de avaliação não corresponde a 100%;
				//------------------------------------------------------------------------------>>
				$soma = 0;
				foreach ($exames as $key => $value) {
					$soma += $value->peso;
				}

				if($soma < 100){
					$error += [
						'soma_menor100'=> 'A pontuação total de avaliação se encontra com peso menor do que 100pts.',
					];
				}
				//------------------------------------------------------------------------------>>
				// - Dia de exame avaliativo válido [selecionado nas configurações do plano]
				$dia_invalido = false;
				$dia_subst = false;
				foreach($exames as $key => $value){
					//conferir se dia do exame é um dia de substituição
					if(in_array($value->data, $dias_troca)){
						//conferir se o dia correspondente da troca em questão é dia letivo
						$dia_subst = \DB::table('trocas')
								->where('dia', '=', $value->data)
								->select('exames.substituicao')
								->first(); 
						$dia_subst_number = $this->parseStringDayToNumber($dia_subst);
						if(!in_array($dia_subst_number, $diasL_semana)){
							$dia_invalido = true;
							$dia_subst = true;
						}
					}else{ 
						//conferir se data está configurado como dia letivo
						$dia_semana = date('w', strtotime($value->data));
						if(!in_array($dia_semana, $diasL_semana)){
							$dia_invalido = true;
						}
					}
				}
				if($dia_invalido && $dia_subst){
					$error += [
						'exame_substituicao'=> 'Uma exame está marcado para um dia de substituição letivo. O dia da semana em questão é inválido como dia letivo da turma.',
					];
				}else if($dia_invalido){
					$error += [
						'exame_substituicao'=> 'Um registro na tabela de exames possui data inválida para  os dias letivos da turma.',
					];
				}
				//------------------------------------------------------------------------------>>
				// - Conferir campos vazios
				$campo_vazio = false;
				foreach($exames as $key => $value){
					if($value->descricao == null){
						$campo_vazio = true;
					}else if($value->peso == null){
						$campo_vazio = true;
					}else if($value->data == null){
						$campo_vazio = true;
					}else if($value->conteudo == null){
						$campo_vazio = true;
					}
				}

				if($campo_vazio){
					$error += [
						'exame_campoVazio'=> 'Tabela de exames com campos vazios.',
					];
				}
			//====================================================================>
			//PLANEJAMENTOS
				//------------------------------------------------------------------------------>>
				// - Verifica se existe informações salvas nas tabelas de planejamento
				if($plano->tipo == 1){// - Planejamento por Aula
					if($planAula->isEmpty()){
						$error += [
							'planejamento_empty'=> 'Não há registro salvo na seção de planejamento.',
						];
					}else{
						// - Dia de planejamento por aula válido [selecionado nas configurações do plano]
						$dia_invalido = false;
						$dia_subst = false;
						foreach($planAula as $key => $value){
							// - confere se dia do planejamento é um dia de substituição
							if(in_array($value->data, $dias_troca)){
								// - confere se o dia correspondente da troca em questão é dia letivo
								$dia_subst = \DB::table('trocas')
										->where('dia', '=', $value->data)
										->select('trocas.substituicao')
										->first(); 

								$dia_subst_number = $this->parseStringDayToNumber($dia_subst);
								if(!in_array($dia_subst_number, $diasL_semana)){
									$dia_invalido = true;
									$dia_subst = true;	
								}
							}else{ 
								// - conferir se data está configurado como dia letivo
								$dia_semana = date('w', strtotime($value->data));
								if(!in_array($dia_semana, $diasL_semana)){
									$dia_subst = true;	
								}
							}
						}
						if($dia_invalido && $dia_subst){
							$error += [
								'planejamento_substituicao'=> 'Uma aula está marcada para um dia de substituição letiva. O dia da semana em questão é inválido como dia letivo da turma.',
							];
						}else if($dia_invalido){
							$error += [
								'planejamento_substituicao'=> 'Um registro na tabela de planejamento possui data inválida para os dias letivos da turma.',
							];
						}
						//------------------------------------------------------------------------------>>
						// - Verifica se existe campos vazios
						$campo_vazio = false;
						foreach($planAula as $key => $value){
							if($value->aula == null){
								$campo_vazio = true;
							}else if($value->data == null){
								$campo_vazio = true;
							}else if($value->tipo == null){
								$campo_vazio = true;
							}else if($value->conteudo == null){
								$campo_vazio = true;
							}
						}

						if($campo_vazio){
							$error += [
								'planejamento_campoVazio'=> 'Tabela de planejamento com campos vazios.',
							];
						}
						//------------------------------------------------------------------------------>>
						// - Verificação de sequência numérica das aulas
						$i = 1;
						foreach($planAula as $key => $value){ 
							if($value->aula != $i){
								$value->aula = $i;
								$value->save();
							}
							$i++;
						}
					}
				}else{ // - Planejamento por Unidade
					if($planUnid->isEmpty()){
						$error += [
							'planejamento_empty'=> 'Não há registro salvo na seção de planejamento.',
						];
					}else{
						//------------------------------------------------------------------------------>>
						// - Verifica se existe campos vazios
						$campo_vazio = false;
						foreach($planUnid as $key => $value){
							if($value->unidade == null){
								$campo_vazio = true;
							}else if($value->hora_aula == null){
								$campo_vazio = true;
							}else if($value->descricao == null){
								$campo_vazio = true;
							}
						}

						if($campo_vazio){
							$error += [
								'planejamento_campoVazio'=> 'Tabela de planejamento com campos vazios.',
							];
						}
					}
				}
			//====================================================================>
			if(count($error) == 0){
				$plano->status = "Em Análise";
				$plano->save();
				session()->flash('info', 'O Plano de Ensino foi enviado ao departamento responsável para análise e aprovação!');
				return redirect()->action('PlanoController@index');
			}else{
				return back()->withErrors($error);
			}
		}
		else{
			return back()->with('warnings', 'Este plano de ensino já se encontra em análise, ou já foi aprovado pela assembléia!');
		}
	}

	/**
	 * Converte o dia da semana em texto para número correspondente
	 * @param string $dia_string - dia da semana
	 * @return int número correspondente ao dia da semana
	 */
	public function parseStringDayToNumber($dia_string){	
		switch ($dia_string) {
			case 'Segunda-Feira':
				return 1;	
			break;
			case 'Terça-Feira':
				return 2;
			break;
			case 'Quarta-Feira': 
				return 3;
			break;
			case 'Quinta-Feira':
				return 4;
			break;
			case 'Sexta-Feira':
				return 5;
			break;
			case 'Sábado':
				return 6;
			break;
		}
		return 0;
	}

	/**
	 * Registra o tipo de plano de ensino.
	 * Sendo plano por aula [tipo = 1] ou plano por unidade [tipo = 2]
	 * @param Request $request - Requisição HTTP
	 */
	public function planTipo(Request $request){
		$plano = Plano::findOrFail($request->id);
		$this->authorize('update', $plano);
		$plano->tipo = $request->tipo;
		$plano->save();
		return;
	}

	/**
	 * Renderiza a página de análise dos planos
	 */
	public function aprovacao(){
		$planos = Plano::join('turmas', 'planos.turma_id', '=', 'turmas.id')
			->join('disciplinas', 'turmas.disciplina_id', '=', 'disciplinas.id')
			->where('planos.status', '=', 'Em Análise')
			->orderBy('disciplinas.nome', 'asc')
			->select('planos.*')
			->paginate(10);
		return view('planos.aprovacao')->with(compact('planos'));
	}

	/**
	 * Aprova o plano selecionado
	 * @param int $id - identificador do plano
	 */
	public function aprovar($id){
		$plano = Plano::findOrFail($id);
		$user = User::find(auth()->id());
		
		$pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pTurma = $plano->turma_id;

        if(in_array($pTurma, $pUser)){
			return back()->withError('O plano de ensino não pode ser aprovado pelo usuário dono do mesmo!');
		}else{
			$plano->aprovacao = Carbon::now();
			$plano->status = "Aprovado";
			$plano->save();
			session()->flash('info', 'O Plano de Ensino foi Aprovado com sucesso!');
			return redirect()->action('PlanoController@aprovacao');
		}

	}

	/**
	 * Renderiza a página de registro de pendência, do plano
	 * @param int $id - identificador do plano
	 */	
	public function pendencia($id){
		$plano = Plano::findOrFail($id);
		$pendencias = Pendencia::where('plano_id', $id)->get();
		return view('planos.reg_pend')->with(compact('plano', 'pendencias'));
	}

	/**
	 * Registra uma pendência vinculado ao plano selecionado
	 * @param Request $request - Requisição HTTP
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de análise
	 */
	public function registrarPendencia(Request $request){
		if($request->pendencia == ""){
			return back()->withError('Este campo não deve ser nulo!');	
		}
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

	/**
	 * Renderiza a página de visualização das pendências vinculadas ao plano
	 * @param int $id - identificador do plano
	 */
	public function view_pend($id){
		$plano = Plano::findOrFail($id);
		$pendencias = Pendencia::where('plano_id', $id)->get();
		return view('planos.view_pend')->with(compact('plano', 'pendencias'));
	}

	/**
	 * Remove o plano selecionado do banco de dados
	 * @param int $id - identificador do plano
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function destroy($id){
		$plano = Plano::findOrFail($id);
		$turma = $plano->turma()->first();
		$this->authorize('delete', $plano);

		DB::transaction(function () use($plano, $turma){
			try{
				$plano->delete();
				$turma->users()->detach();
				$turma->delete();
				session()->flash('warning', 'Plano removido com sucesso!');		
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Exclusão do plano falhou. ' . $e->getMessage());
			}
		});
		return redirect('/planos');
	}	
}
