<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanejamentoAula;
use App\Plano;
use App\Http\Requests\PlanAulaRequest;
use App\Http\Requests\UpdatePlanAulaRequest;

class PlanejamentoAulaController extends Controller{	
	/**
	 * Registra um planejamento, na tabela 'planejamento_aulas' do banco de dados, vinculado ao plano selecionado
	 * @param PlanAulaRequest $request - Requisição HTTP com campos validados
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
	public function store(PlanAulaRequest $request){
		$plano = Plano::findOrFail($request->plano_id);
		$planA = new PlanejamentoAula;

		$planA->aula = $request->aula;
		$planA->tipo = $request->tipo;
		$planA->data = $request->data;
		$planA->conteudo = $request->conteudo;
		$planA->plano_id = $request->plano_id;

		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$planA->save();

		session()->flash('info', 'Planejamento de aula inserido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}

	/**
	 * Atualiza um planejamento, na tabela 'planejamento_aulas' do banco de dados, vinculado ao plano selecionado
	 * @param UpdatePlanAulaRequest $request - Requisição HTTP com campos validados
	 * @param int $id - identificador do planejamento selecionado
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
	public function update(UpdatePlanAulaRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planA = PlanejamentoAula::findOrFail($id);

		$data_igual =  \DB::table('planejamento_aulas')    
                    ->where('data', '=', $request->data)
					->where('plano_id', '=', $request->plano_id)
					->where('id', '!=', $id)
                    ->count();

		if($data_igual > 0){
			return back()->withError('O campo data selecionado já se encontra registrado na tabela de planejamentos.');	
		}

		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
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

	/**
	 * Remove um planejamento, na tabela 'planejamento_aulas', do banco de dados.
	 * @param Request $request - Requisição HTTP
	 * @param int $id - identificador do planejamento selecionado
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index dos planejamentos
	 */
	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$planA = PlanejamentoAula::findOrFail($id);

		$this->authorize('crud', $planA);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$planA->delete();
		session()->flash('warning', 'Planejamento de aula removido com sucesso!');
		return redirect('/planos/'.$plano->id.'/planejamentos')->with('plano', $plano);
	}
}
