<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Semestre;
use App\Feriado;
use App\Http\Requests\FeriadoRequest;
use App\Http\Requests\UpdateFeriadoRequest;

class FeriadoController extends Controller{
	/**
	 * Renderiza a página de index dos feriados, com os feriados cadastrados.
	 */
    public function index(){
    	$feriados = Feriado::paginate(10);
    	return view('feriados.index')->with('feriados', $feriados);
	}
	
	/**
	 * Renderiza a página de registro dos feriados
	 */
    public function create(){
		$semestres = Semestre::orderBy('inicio','desc')->get();
    	return view('feriados.create')->with('semestres', $semestres);
	}
	
	/**
	 * Registra um feriado no banco de dados.
	 * @param FeriadoRequest $request - Requisição HTTP com campos validados
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function store(FeriadoRequest $request){
		Feriado::create($request->all());
		session()->flash('info', 'Feriado adicionado com sucesso!');
		return redirect('/feriados');
	} 

	/**
	 * Renderiza a página de atualização do feriado selecionado.
	 * @param int $id - identificador do feriado selecionado
	 */
	public function edit($id){
		$semestres = Semestre::orderBy('inicio','desc')->get();
		$feriado = Feriado::findOrFail($id);
		return view('feriados.edit')->with( compact('feriado', 'semestres'));
	}

	/**
	 * Atualiza um registro do feriado no banco de dados
	 * @param UpdateFeriadoRequest $request - Requisição HTTP com campos validados
	 * @param int $id - identificador do feriado selecionado
	 */
	public function update(UpdateFeriadoRequest $request, $id){
		$feriado = Feriado::findOrFail($id);
		$feriado->data = $request->data;
		$feriado->semestre_id = $request->semestre_id;

		$feriado->save();
		session()->flash('info', 'Feriado atualizado com sucesso!');
		return redirect('/feriados');
	}

	/**
	 * Remove um registro do feriado no banco de dados.
	 * @param int $id - identificador do feriado selecionado
	 */
	public function destroy($id){
	 	Feriado::destroy($id);
		session()->flash('warning', 'Feriado removido com sucesso!');
	 	return redirect('/feriados');
	}

	/**
	 * Busca as informações do semestre selecionado
	 * @return \Illuminate\Http\JsonResponse $array - dia, mês, ano dos campos início e fim do semestre selecionado
	 */
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
