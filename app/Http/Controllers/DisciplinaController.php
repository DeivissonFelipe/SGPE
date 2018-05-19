<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disciplina;
use App\Departamento;
use App\Curso;
use App\Turma;
use App\Http\Requests\DisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;

class DisciplinaController extends Controller
{
    public function index(){
    	$disciplinas = Disciplina::orderBy('nome', 'asc')->paginate(7);
    	return view('disciplinas.index')->with('disciplinas', $disciplinas);
    }

    public function create(){
    	$departamentos = Departamento::orderBy('sigla', 'asc')->get();
        return view ('disciplinas.create')->with(compact('departamentos'));
    }

	public function store(DisciplinaRequest $request){
		$disciplina = Disciplina::create($request->all());
		$cursosOferta = $request->oferta;
		$this->syncDisciplinaCurso($cursosOferta, $disciplina);

		session()->flash('info', 'Disciplina inserida com sucesso!');
		return redirect('/disciplinas');
	}

	public function edit($id){
		$departamentos = Departamento::orderBy('sigla', 'asc')->get();
		$disciplina = Disciplina::find($id);
		return view('disciplinas.edit')->with(compact('departamentos', 'disciplina'));
	}

	public function update(UpdateDisciplinaRequest $request, $id){
		$disciplina = Disciplina::find($id);
		$disciplina->codigo = $request->codigo;
		$disciplina->nome = $request->nome;
		$disciplina->name = $request->name;
		$disciplina->chsemestral = $request->chsemestral;
		$disciplina->chsemanalp = $request->chsemanalp;
		$disciplina->chsemanalt = $request->chsemanalt;
         
		$disciplina->departamento_id = $request->departamento_id;

		$disciplina->save();
		$disciplina->cursos()->detach();
	
		$cursosOferta = $request->oferta;
		$this->syncDisciplinaCurso($cursosOferta, $disciplina);
		$this->updateNumeroTurma($cursosOferta, $disciplina->id);
	
		session()->flash('info', 'Disciplina atualizada com sucesso!');
		return redirect('/disciplinas');
	}

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
			$value->numero_turma = $numeroTurma;
			$value->save();	
		}
	}

	public function destroy($id){
		$disciplina = Disciplina::find($id);
		if(count($disciplina->turmas()->get()) > 0){
			return back()->with('error', 'Exclusão da disciplina Falhou! Há alguma turma vinculada à esta disciplina.');
		}else{
			$turma->cursos()->detach();
			Disciplina::destroy($id);
			session()->flash('warning', 'Disciplina removida com sucesso!');
			return redirect('/disciplinas');
		}
	}
}
