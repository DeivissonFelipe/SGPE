<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
use App\Http\Requests\CursoRequest;
use App\Http\Requests\UpdateCursoRequest;

class CursoController extends Controller
{
    public function index(){
		$cursos = Curso::orderBy('nome', 'asc')->paginate(10);
		return view('cursos.index')->with('cursos', $cursos);
    }
    public function create(){
    	return view('cursos.create');
	}
	public function store(CursoRequest $request){
		Curso::create($request->all());
        session()->flash('info', 'Curso inserido com sucesso!');
        return redirect('/cursos');
	}
	public function edit($id){
		$curso = Curso::findOrFail($id);
        return view('cursos.edit')
            ->with('curso', $curso);
	}
	public function update(UpdateCursoRequest $request, $id){
		$curso = Curso::findOrFail($id);
        $curso->nome = $request->nome;
        $curso->sigla = $request->sigla;
        
        $curso->save();
        session()->flash('info', 'Curso atualizado com sucesso!');
        return redirect('/cursos');
	}
	public function destroy($id){
		$curso = Curso::findOrFail($id);
		if(count($curso->disciplinas()->get())>0){
			return back()->with('error', 'Exclusão do Curso Falhou! Há alguma disciplina vinculada à este curso.');
		}elseif(count($curso->turmas()->get())>0){
			return back()->with('error', 'Exclusão do Curso Falhou! Há alguma turma vinculada à este curso.');
		}else{
			Curso::destroy($id);
			session()->flash('warning', 'Curso removido com sucesso!');
			return redirect('/cursos');
		}
	}
}
