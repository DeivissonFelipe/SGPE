<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semestre;
use App\Http\Requests\SemestreRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class SemestreController extends Controller
{
    public function index(){
    	$semestres = Semestre::orderBy('inicio','desc')->paginate(10);
    	return view('semestres.index')->with('semestres', $semestres);
    }

    public function create(){
    	return view('semestres.create');
    }

	public function store(SemestreRequest $request){
		Semestre::create($request->all());
		session()->flash('info', 'Semestre inserido com sucesso!');
		return redirect('/semestres');
	}

	public function show($id){
		$semestre = Semestre::findOrFail($id);
		return view('semestres.show')->with('semestre', $semestre);
	}

	public function edit($id){
		$semestre = Semestre::findOrFail($id);
		return view('semestres.edit')->with('semestre', $semestre);
	}

	public function update(UpdateSemestreRequest $request, $id){
		$semestre = Semestre::findOrFail($id);
		$semestre->rotulo = $request->rotulo;
		$semestre->inicio = $request->inicio;
		$semestre->fim = $request->fim;

		$semestre->save();
		session()->flash('info', 'Semestre atualizado com sucesso!');
		return redirect('/semestres');
	}

	public function destroy($id){
		$semestre = Semestre::findOrFail($id);
		if(count($semestre->turmas()->get())>0){
			return back()->with('error', 'Exclusão do Semestre Falhou! Há alguma turma vinculada à este Semestre.');
		}else{
			DB::transaction(function () use($semestre, $id){
				try{
					$semestre->feriados()->delete();
					$semestre->trocas()->delete();
					Semestre::destroy($id);
					session()->flash('warning', 'Semestre removido com sucesso!');
				}
				catch(\Exception $e){
					DB::rollBack();
					return back()->withError('Exclusão do semestre Falhou. ' . $e->getMessage());
				}
			});
			return redirect('/semestres');
		}
	}
}
