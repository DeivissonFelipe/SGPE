<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disciplina;
use App\Departamento;
use App\Curso;
use App\Turma;
use App\Http\Requests\DisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class DisciplinaController extends Controller{
	/**
	 * Renderiza a página de index das disciplinas, com as disciplinas cadastradas.
	 */
    public function index(){
    	$disciplinas = Disciplina::orderBy('nome', 'asc')->paginate(10);
    	return view('disciplinas.index')->with('disciplinas', $disciplinas);
    }

	/**
	 * Renderiza a página de registro das disciplinas.
	 */
    public function create(){
    	$departamentos = Departamento::orderBy('sigla', 'asc')->get();
        return view ('disciplinas.create')->with(compact('departamentos'));
    }

	/**
	 * Registra uma disciplina no banco de dados.
	 * @param DisciplinaRequest $request - Requisição HTTP com campos validados.
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function store(DisciplinaRequest $request){
		if(empty($request->oferta)){
			return back()->withError('Criação da disciplina Falhou. É necessário selecionar, pelo menos, um curso para ofertar a disciplina!');
		}
		DB::transaction(function() use($request){
			try{
				$disciplina = Disciplina::create($request->all());
				$cursosOferta = $request->oferta;
				$this->syncDisciplinaCurso($cursosOferta, $disciplina);
				session()->flash('info', 'Disciplina inserida com sucesso!');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Criação da disciplina Falhou. ' . $e->getMessage());
			}
		});
		return redirect('/disciplinas');
	}

	/**
	 * Renderiza a página de atualização da disciplina selecionada.
	 * @param int $id - identificador da disciplina selecionada
	 */
	public function edit($id){
		$departamentos = Departamento::orderBy('sigla', 'asc')->get();
		$disciplina = Disciplina::find($id);
		return view('disciplinas.edit')->with(compact('departamentos', 'disciplina'));
	}

	/**
	 * Atualiza um registro de disciplina no banco de dados
	 * @param UpdateDisciplinaRequest $request - Requisição HTTP com campos validados.
	 * @param int $id - identificador da disciplina selecionada
	 */
	public function update(UpdateDisciplinaRequest $request, $id){
		if(empty($request->oferta)){
			return back()->withError('Criação da disciplina Falhou. É necessário selecionar, pelo menos, um curso para ofertar a disciplina!');
		}
		
		$disciplina = Disciplina::findOrFail($id);
		$disciplina->codigo = $request->codigo;
		$disciplina->nome = $request->nome;
		$disciplina->name = $request->name;
		$disciplina->chsemestral = $request->chsemestral;
		$disciplina->chsemanalp = $request->chsemanalp;
		$disciplina->chsemanalt = $request->chsemanalt;
		$disciplina->departamento_id = $request->departamento_id;
         
		DB::transaction(function () use($disciplina, $request){
			try{
				$disciplina->save();
				$disciplina->cursos()->detach();
				$cursosOferta = $request->oferta;
				$this->syncDisciplinaCurso($cursosOferta, $disciplina);
				$this->updateNumeroTurma($cursosOferta, $disciplina->id);
				session()->flash('info', 'Disciplina atualizada com sucesso!');
			}
			catch(\Exception $e){
				DB::rollBack();
				return back()->withError('Atualização da disciplina Falhou. ' . $e->getMessage());
			}
		});	
		return redirect('/disciplinas');
	}

	/**
	 * Vincula uma disciplina com os cursos que ofertam a disciplina em questão.
	 * O registro do vinculo ocorre na tabela 'disciplina_curso'
	 * 
	 * @param array $cursosOferta - array contendo os valores (int) correspondente aos cursos no formulário
	 * @param \App\Disciplina $disciplina - instância da disciplina a ser vinculada
	 * @return void
	 */
	public function syncDisciplinaCurso($cursosOferta, $disciplina){
		foreach ($cursosOferta as $key => $value) {
			switch ($value) {
				case '1'://Engenharia de Produção
					$id_curso = Curso::where('sigla', '=', 'EP')
								->select('id')
								->first();
					$disciplina->cursos()->sync($id_curso, false);
				break;
				case '2'://Sistemas de Informação
					$id_curso = Curso::where('sigla', '=', 'SI')
								->select('id')
								->first();
					$disciplina->cursos()->sync($id_curso, false);
				break;
				case '3'://Engenharia Elétrica
					$id_curso = Curso::where('sigla', '=', 'EE')
								->select('id')
								->first();
					$disciplina->cursos()->sync($id_curso, false);
				break;
				case '4'://Engenharia de Computação
					$id_curso = Curso::where('sigla', '=', 'EC')
								->select('id')
								->first();
					$disciplina->cursos()->sync($id_curso, false);
				break;
			}
		}
	}

	/**
	 * Atualiza o número da turma de todos os planos vinculados à disciplina selecionada.
	 * @param int $disciplina_id - identificador da disciplina
	 */
	public function updateNumeroTurma($disciplina_id){
		$turmas = Turma::where('disciplina_id', '=', $disciplina_id)->get();
		foreach ($turmas as $key => $value) {
			$curso = $value->curso->sigla;
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

			//1º algorismo (qtd de registro)
			$qtd = count($result);
			
			//2º algorismo 
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
			
			// numero turma =  nº1 concatenado com nº2
			$numeroTurma = $qtd . $contador;
			$value->numero_turma = $numeroTurma;
			$value->save();	
		}
	}

	/**
	 * Remove um registro de disciplina no banco de dados.
	 * @param int $id - identificador da disciplina selecionada
	 */
	public function destroy($id){
		$disciplina = Disciplina::findOrFail($id);
		if(count($disciplina->turmas()->get()) > 0){
			return back()->with('error', 'Exclusão da disciplina Falhou! Há alguma turma vinculada à esta disciplina.');
		}else{
			DB::transaction(function() use($disciplina, $id){
				try{
					$disciplina->cursos()->detach();
					Disciplina::destroy($id);
					session()->flash('warning', 'Disciplina removida com sucesso!');
				}
				catch(\Exception $e){
					DB::rollBack();
					return back()->withError('Exclusão da disciplina Falhou. ' . $e->getMessage());
				}
			});
			return redirect('/disciplinas');
		}
	}

	/**
	 * Renderiza a página de informações da disciplina selecionada
	 * @param int $id - identificador da disciplina selecionada
	 */
	public function info($id){
		$disciplina = Disciplina::find($id);
		return view('disciplinas.info')->with(compact('disciplina'));
	}

	/**
	 * Registra o campo de ementa no registro da disciplina, contida no banco de dados.
	 * @param Request $request - Requisição HTTP
	 */
	public function ementa(Request $request){
		$disciplina = Disciplina::findOrFail($request->disciplina_id);
		$disciplina->ementa = $request->ementa;
		$disciplina->save();
		session()->flash('info', 'Campo ementa atualizado com sucesso!');
		return redirect('/disciplinas/'.$disciplina->id.'/info#ementa')->with('disciplina', $disciplina);
	}

	/**
	 * Registra o campo de conteúdo no registro da disciplina, contida no banco de dados.
	 * @param Request $request - Requisição HTTP
	 */
	public function conteudo(Request $request){
		$disciplina = Disciplina::findOrFail($request->disciplina_id);
		$disciplina->conteudo = $request->conteudo;
		$disciplina->save();
		session()->flash('info', 'Campo conteudo atualizado com sucesso!');
		return redirect('/disciplinas/'.$disciplina->id.'/info#conteudo')->with('disciplina', $disciplina);
	}

	/**
	 * Registra o campo de bibliografia básica no registro da disciplina, contida no banco de dados.
	 * @param Request $request - Requisição HTTP
	 */
	public function bibliografiab(Request $request){
		$disciplina = Disciplina::findOrFail($request->disciplina_id);
		$disciplina->bibliografiab = $request->bibliografiab;
		$disciplina->save();
		session()->flash('info', 'Campo bibliografia básica atualizado com sucesso!');
		return redirect('/disciplinas/'.$disciplina->id.'/info#bibb')->with('disciplina', $disciplina);
	}

	/**
	 * Registra o campo de bibliografia complementar no registro da disciplina, contida no banco de dados.
	 * @param Request $request - Requisição HTTP
	 */
	public function bibliografiac(Request $request){
		$disciplina = Disciplina::findOrFail($request->disciplina_id);
		$disciplina->bibliografiac = $request->bibliografiac;
		$disciplina->save();
		session()->flash('info', 'Campo bibliografia complementar atualizado com sucesso!');
		return redirect('/disciplinas/'.$disciplina->id.'/info#bibc')->with('disciplina', $disciplina);
	}

























}
