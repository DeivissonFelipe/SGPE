<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TurmaRequest;
use App\Turma;
use App\User;
use App\Disciplina;
use App\Semestre;
use App\Curso;
use App\Role;
use App\Plano;
use Exception;
use Illuminate\Support\Facades\DB;

class TurmaController extends Controller{
    public function index(){
		$turmas = Turma::join('disciplinas', 'disciplinas.id', '=', 'turmas.disciplina_id')
					->orderBy('disciplinas.nome', 'asc')
					->select(['turmas.*'])
					->paginate(10);
		
    	return view('turmas.index')->with('turmas', $turmas);
    }
    public function create(){
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
    	return view('turmas.create')->with(compact('users','disciplinas','semestres','cursos'));
	}
	public function store(TurmaRequest $request){

		$users = $request->user_id;
		
		if(!in_array(auth()->id(), $users)){
			if(!User::find(auth()->id())->hasRole('Admin')){
				return back()->withErrors('A criação da turma falhou! Seu nome não está incluso como professor da turma.');
			}
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

				$plano = new Plano();
				$plano->turma_id = $turma->id;
				$plano->tipo = 1;
				$plano->status = 'Em Edição';
				$plano->save();
				session()->flash('info', 'Turma inserida com sucesso!');
			}catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Criação da turma Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/turmas');
	}
	public function edit($id){
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

		$turma = Turma::find($id);
		return view('turmas.edit')->with(compact('users','disciplinas', 'semestres', 'cursos', 'turma'));
	}
	public function update(TurmaRequest $request, $id){
		$turma = Turma::findOrFail($id);
		$this->authorize('owner', $turma);

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
				session()->flash('info', 'Turma atualizada com sucesso!');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Atualização da turma Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/turmas');
	}
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
		
		// numero turma apend nº1 + nº2
		$numeroTurma = $qtd . $contador;
		$turma->numero_turma = $numeroTurma;
		$turma->save();	
	}
	public function destroy($id){
		$turma = Turma::findOrFail($id);
		$this->authorize('owner', $turma);
		
		$cont = 0;
		$cont+= count($turma->planos()->first()->atendimentos()->get());
		$cont+= count($turma->planos()->first()->planejamentoAulas()->get());
		$cont+= count($turma->planos()->first()->planejamentoUnidades()->get());
		$cont+= count($turma->planos()->first()->horarios()->get());
		$cont+= count($turma->planos()->first()->exames()->get());
		$cont+= count($turma->planos()->first()->pendencias()->get());

		if($cont > 0){
			return back()->with('error', 'Exclusão da turma Falhou! Há algum registro vinculado ao plano correspondente.');
		}else{
			DB::transaction(function () use($turma){
				try{
					$turma->planos()->delete();
					$turma->users()->detach();
					$turma->delete();
					session()->flash('warning', 'Turma removida com sucesso!');		
				}
				catch(\Exception $e){
					DB::rollBack();
					return back()->withError('Exclusão da turma Falhou. ' . $e->getMessage());
				}
			});
			return redirect('/turmas');
		}
	}
}
