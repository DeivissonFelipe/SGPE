<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Semestre;
use App\Feriado;
use App\Http\Requests\FeriadoRequest;


class FeriadoController extends Controller
{
    public function index(){
    	$feriados = Feriado::paginate(10);
    	return view('feriados.index')->with('feriados', $feriados);
    }
    
    public function create(){
    	$semestres = Semestre::all();
    	return view('feriados.create')->with('semestres', $semestres);
    }

	public function store(FeriadoRequest $request){
		Feriado::create($request->all());
		session()->flash('info', 'Feriado adicionado com sucesso!');
		return redirect('/feriados');
	}
	
	public function edit($id){
		$semestres = Semestre::all();
		$feriado = Feriado::findOrFail($id);
		return view('feriados.edit')->with( compact('feriado', 'semestres'));
	}

	public function update(UpdateFeriadoRequest $request, $id){
		$feriado = Feriado::findOrFail($id);
		$feriado->data = $request->data;
		$feriado->semestre_id = $request->semestre_id;

		$feriado->save();
		session()->flash('info', 'Feriado atualizado com sucesso!');
		return redirect('/feriados');
	}
	
	public function destroy($id){
	 	Feriado::destroy($id);
		session()->flash('warning', 'Feriado removido com sucesso!');
	 	return redirect('/feriados');
	}

	public function ajaxSemestre(){
		$id = Input::get('id');
		$semestre = Semestre::findOrFail($id);
		$array = [
			'd_inicio' => Carbon::parse($semestre->inicio)->day,
			'm_inicio' =>  Carbon::parse($semestre->inicio)->month,
			'y_inicio' =>  Carbon::parse($semestre->inicio)->year,
			'd_fim' =>  Carbon::parse($semestre->fim)->day,
			'm_fim' =>  Carbon::parse($semestre->fim)->month,
			'y_fim' =>  Carbon::parse($semestre->fim)->year,
		];
		return Response::json($array);
	}
}
