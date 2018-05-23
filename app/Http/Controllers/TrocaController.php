<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Troca;
use App\Semestre;
use App\Http\Requests\TrocaRequest;

class TrocaController extends Controller
{
    public function index(){
    	$trocas = Troca::orderBy('dia', 'desc')->paginate(10);
    	return view('trocas.index')->with('trocas', $trocas);
    }
    public function create(){
		$semestres = Semestre::orderBy('inicio','desc')->get();
		$diasNaoLetivos = array();
		$feriados = $semestres->first()->feriados()->get();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		$diasNaoLetivos = json_encode($diasNaoLetivos);

    	return view('trocas.create')->with(compact('semestres', 'diasNaoLetivos'));
    }
	public function store(TrocaRequest $request){
		Troca::create($request->all());
		session()->flash('info', 'Substituição de dia letivo registrada com sucesso!');
		return redirect('/trocas');
	}
	
	public function edit($id){
		$troca = Troca::findOrFail($id);
		$semestres = Semestre::orderBy('inicio','desc')->get();
		$dias = ['Segunda-Feira','Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira'];
		$diasNaoLetivos = array();
		$feriados = $semestres->first()->feriados()->get();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		$diasNaoLetivos = json_encode($diasNaoLetivos);

		return view('trocas.edit')->with(compact('troca','dias', 'semestres','diasNaoLetivos'));
	}
	public function update(UpdateTrocaRequest $request, $id){
		$troca = Troca::findOrFail($id);
		$troca->dia = $request->dia;
		$troca->substituicao = $request->substituicao;
		$troca->semestre_id = $request->semestre_id;

		$troca->save();
		session()->flash('info', 'Substituição de dia letivo atualizada com sucesso!');
		return redirect('/trocas');
	}
	public function destroy($id){
		Troca::destroy($id);
		session()->flash('warning', 'Substituição de dia letivo removida com sucesso!');
		return redirect('/trocas');
	}
	public function ajaxSemestre(){
		$id = Input::get('id');
		$semestre = Semestre::find($id);

		$diasNaoLetivos = array();
		$feriados = $semestre->feriados()->get();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		
		$array = [
			'd_inicio' => Carbon::parse($semestre->inicio)->day,
			'm_inicio' =>  Carbon::parse($semestre->inicio)->month,
			'y_inicio' =>  Carbon::parse($semestre->inicio)->year,
			'd_fim' =>  Carbon::parse($semestre->fim)->day,
			'm_fim' =>  Carbon::parse($semestre->fim)->month,
			'y_fim' =>  Carbon::parse($semestre->fim)->year,
			'diasNaoLetivos' => $diasNaoLetivos,
		];
		return Response::json($array);
	}
}
