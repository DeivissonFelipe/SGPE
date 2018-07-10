<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Requests\DepartamentoRequest;
use App\Http\Requests\UpdateDepartamentoRequest;

class DepartamentoController extends Controller{
	/**
	 * Renderiza a página de index dos departamentos, com os departamentos cadastrados.
	 */
    public function index(){
    	$departamentos = Departamento::orderBy('nome','asc')->get();
    	return view('departamentos.index')->with('departamentos', $departamentos);
	}
	
	/**
	 * Renderiza a página de registro dos departamentos.
	 */
    public function create(){
    	return view('departamentos.create');
	}
	
	/**
	 * Registra um departamento no banco de dados.
	 * @param DepartamentoRequest $request - Requisição HTTP com campos validados.
	 * @return Illuminate\Http\RedirectResponse - Retorna a página de index
	 */
	public function store(DepartamentoRequest $request){
		Departamento::create($request->all());
		session()->flash('info', 'Departamento inserido com sucesso!');
		return redirect('/departamentos');
	}

	/**
	 * Renderiza a página de atualização do departamento selecionado.
	 * @param int $id - identificador do departamento selecionado
	 */
	public function edit($id){
		$departamento = Departamento::findOrFail($id);
		return view('departamentos.edit')->with('departamento', $departamento);
	}

	/**
	 * Atualiza um registro de departamento no banco de dados.
	 * @param UpdateDepartamentoRequest $request - Requisição HTTP com campos validados.
	 * @param int $id - identificador do departamento selecionado
	 */
	public function update(UpdateDepartamentoRequest $request, $id){
		$departamento = Departamento::findOrFail($id);
		$departamento->nome = $request->nome;
		$departamento->sigla = $request->sigla;

		$departamento->save();
		session()->flash('info', 'Departamento atualizado com sucesso!');
		return redirect('/departamentos');
	}

	/**
	 * Remove um registro de departamento no banco de dados.
	 * @param int $id - identificador do departamento selecionado
	 */
	public function destroy($id){
		$departamento = Departamento::findOrFail($id);
		if(count($departamento->disciplinas()->get()) > 0){
			return back()->with('error', 'Exclusão do departamento Falhou! Há alguma disciplina vinculada à este departamento.');
		}
		else{
			Departamento::destroy($id);
			session()->flash('warning', 'Departamento removido com sucesso!');
			return redirect('/departamentos');
		}

	}
}
