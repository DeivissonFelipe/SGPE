<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Horario;
use App\Plano;
use App\Http\Requests\HorarioRequest;

class HorarioController extends Controller{
	public function aula($id){
		$plano = Plano::findOrFail($id);
		$semestre = $plano->turma()->first()->semestre()->first();
		$feriados = $semestre->feriados()->get();

		$diasNaoLetivos = array();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		$diasNaoLetivos = json_encode($diasNaoLetivos);
		return view('planos.partials-edit.horario')->with(compact('plano','semestre','diasNaoLetivos'));
	}

	public function store(HorarioRequest $request){
		$plano = Plano::findOrFail($request->plano_id);
		$horario = new Horario;

		$horario->dia = $request->dia;
		$horario->inicio = $request->inicio;
		$horario->fim = $request->fim;
		$horario->plano_id = $request->plano_id;

		$this->authorize('crud', $horario);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$horario->save();

		session()->flash('info', 'Horário de aula inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/aula')->with('plano', $plano);
	}
	
	public function update(HorarioRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$horario = Horario::findOrFail($id);
		$this->authorize('crud', $horario);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}

		$horario->dia = $request->dia;
		$horario->inicio = $request->inicio;
		$horario->fim = $request->fim;
		$horario->plano_id = $request->plano_id;

		$horario->save();
		session()->flash('info', 'Horário de aula atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/aula')->with('plano', $plano);
	}
	
	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$horario = Horario::findOrFail($id);

		$this->authorize('crud', $horario);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$horario->delete();
		session()->flash('warning', 'Horário de aula removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/aula')->with('plano', $plano);
	}
}
