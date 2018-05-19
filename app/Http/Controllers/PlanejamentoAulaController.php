<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanejamentoAula;
use App\Plano;
use App\Http\Requests\PlanAulaRequest;

class PlanejamentoAulaController extends Controller{
	
	public function store(PlanAulaRequest $request){
		$plano = Plano::find($request->plano_id);
		$planA = new PlanejamentoAula;

		$planA->aula = $request->aula;
		$planA->tipo = $request->tipo;
		$planA->data = $request->data;
		$planA->conteudo = $request->conteudo;
		$planA->plano_id = $request->plano_id;

		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$planA->save();

		session()->flash('info', 'Planejamento de aula inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
	
	public function update(PlanAulaRequest $request, $id){
		$plano = Plano::find($request->plano_id);
		$planA = PlanejamentoAula::find($id);
		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}

		$planA->aula = $request->aula;
		$planA->tipo = $request->tipo;
		$planA->data = $request->data;
		$planA->conteudo = $request->conteudo;
		$planA->plano_id = $request->plano_id;

		$planA->save();
		session()->flash('info', 'Planejamento por aula atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);

	}

	public function destroy(Request $request, $id){
		$plano = Plano::find($request->plano_id);
		$planA = PlanejamentoAula::find($id);

		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$planA->delete();
		session()->flash('warning', 'Planejamento de aula removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
}
