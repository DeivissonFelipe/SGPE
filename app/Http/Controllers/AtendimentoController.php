<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento;
use App\Plano;
use App\Http\Requests\AtendimentoRequest;

class AtendimentoController extends Controller
{  
	public function atendimento($id){
		$plano = Plano::findOrFail($id);
		return view('planos.partials-edit.atendimento')->with('plano', $plano);
	}

	public function store(AtendimentoRequest $request){
		$plano = Plano::findOrFail($request->plano_id);
		$atendimento = new Atendimento;

		$atendimento->dia = $request->dia;
		$atendimento->inicio = $request->inicio;
		$atendimento->fim = $request->fim;
		$atendimento->sala = $request->sala;
		$atendimento->plano_id = $request->plano_id;

		$this->authorize('crud', $atendimento);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$atendimento->save();

		session()->flash('info', 'Horário de Atendimento inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/atendimentos')->with('plano', $plano);
	}

	public function update(AtendimentoRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$atendimento = Atendimento::findOrFail($id);
		$this->authorize('crud', $atendimento);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		
		$atendimento->dia = $request->dia;
		$atendimento->inicio = $request->inicio;
		$atendimento->fim = $request->fim;
		$atendimento->sala = $request->sala;
		$atendimento->plano_id = $request->plano_id;

		$atendimento->save();
		session()->flash('info', 'Horário de atendimento atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/atendimentos')->with('plano', $plano);
	}

	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$atendimento = Atendimento::findOrFail($id);

		$this->authorize('crud', $atendimento);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$atendimento->delete();
		session()->flash('warning', 'Horário de Atendimento removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/atendimentos')->with('plano', $plano);
	}
}
