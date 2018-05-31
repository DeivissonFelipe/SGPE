<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exame;
use App\Plano;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExameRequest;

class ExameController extends Controller{
	public function exame($id){
		$plano = Plano::findOrFail($id);
		$semestre = $plano->turma()->first()->semestre()->first();
		$feriados = $semestre->feriados()->get();

		$diasNaoLetivos = array();
		foreach ($feriados as $key => $value) {
			array_push($diasNaoLetivos, $value->data);
		}
		$diasNaoLetivos = json_encode($diasNaoLetivos);
		return view('planos.partials-edit.exame')->with(compact('plano','semestre','diasNaoLetivos'));
	}
	public function store(ExameRequest $request){
		$plano = Plano::findOrFail($request->plano_id);
		$exame = new Exame;

		$exame->descricao = $request->descricao;
		$exame->peso = $request->peso;
		$exame->data = $request->data;
		$exame->conteudo = $request->conteudo;
		$exame->plano_id = $request->plano_id;

		$this->authorize('crud', $exame);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$exame->save();
		
		session()->flash('info', 'Avaliação inserida com sucesso!');
		return redirect('/planos/'.$plano->id.'/exames')->with('plano', $plano);
	}
	public function update(ExameRequest $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$exame = Exame::findOrFail($id);
		$this->authorize('crud', $exame);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}

		$exame->descricao = $request->descricao;
		$exame->peso = $request->peso;
		$exame->data = $request->data;
		$exame->conteudo = $request->conteudo;
		$exame->plano_id = $request->plano_id;

		$exame->save();
		session()->flash('info', 'Exame avaliativo atualizado com sucesso!');
		return redirect('/planos/'. $request->plano_id .'/exames')->with('plano', $plano);
	}
	public function destroy(Request $request, $id){
		$plano = Plano::findOrFail($request->plano_id);
		$exame = Exame::findOrFail($id);

		$this->authorize('crud', $exame);
		if($plano->status != 'Em Edição'){
			$plano->status = 'Em Edição';
			$plano->save();
		}
		$exame->delete();
		session()->flash('warning', 'Avaliação removida com sucesso!');
		return redirect('/planos/'.$plano->id.'/exames')->with('plano', $plano);
	}
}

