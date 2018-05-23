<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanejamentoUnidade;
use App\Plano;
use App\Http\Requests\PlanUnidRequest;

class PlanejamentoUnidadeController extends Controller{

    public function store(PlanUnidRequest $request){
		$plano = Plano::findOrFail($request->plano_id);
		$planU = new PlanejamentoUnidade;

		$planU->unidade = $request->unidade;
		$planU->hora_aula = $request->hora_aula;
		$planU->descricao = $request->descricao;
		$planU->plano_id = $request->plano_id;

		$this->authorize('crud', $planU);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$planU->save();
		
		session()->flash('info', 'Planejamento de aula inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
	
	public function update(PlanUnidRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planU = PlanejamentoUnidade::findOrFail($id);
		$this->authorize('crud', $planU);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}

		$planU->unidade = $request->unidade;
		$planU->hora_aula = $request->hora_aula;
		$planU->descricao = $request->descricao;
		$planU->plano_id = $request->plano_id;

		$planU->save();
		session()->flash('info', 'Planejamento por unidade atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}

	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planU = PlanejamentoUnidade::findOrFail($id);

		$this->authorize('crud', $planU);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
		}
		$planU->delete();
		session()->flash('warning', 'Planejamento de aula removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
}
