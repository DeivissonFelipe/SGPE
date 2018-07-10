<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanejamentoUnidade;
use App\Plano;
use App\Http\Requests\PlanUnidRequest;

class PlanejamentoUnidadeController extends Controller{
	/**
	 * Registra um planejamento, na tabela 'planejamento_unidades' do banco de dados, vinculado ao plano selecionado
	 * @param PlanUnidRequest $request - Requisição HTTP com campos validados
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
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
			$plano->save();
		}
		$planU->save();
		
		session()->flash('info', 'Planejamento de aula inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}

	/**
	 * Atualiza um planejamento, na tabela 'planejamento_unidades' do banco de dados, vinculado ao plano selecionado
	 * @param PlanUnidRequest $request - Requisição HTTP com campos validados
	 * @param int @id - identificador do planejamento selecionado
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
	public function update(PlanUnidRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planU = PlanejamentoUnidade::findOrFail($id);
		$this->authorize('crud', $planU);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}

		$planU->unidade = $request->unidade;
		$planU->hora_aula = $request->hora_aula;
		$planU->descricao = $request->descricao;
		$planU->plano_id = $request->plano_id;

		$planU->save();
		session()->flash('info', 'Planejamento por unidade atualizado com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}

	/**
	 * Remove um planejamento, na tabela 'planejamento_unidades', do banco de dados.
	 * @param Request $request - Requisição HTTP
	 * @param int $id - identificador do planejamento selecionado
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planU = PlanejamentoUnidade::findOrFail($id);

		$this->authorize('crud', $planU);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$planU->delete();
		session()->flash('warning', 'Planejamento de aula removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
}
