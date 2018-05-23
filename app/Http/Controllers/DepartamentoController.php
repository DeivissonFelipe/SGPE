<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Requests\DepartamentoRequest;

class DepartamentoController extends Controller
{
    public function index(){
    	$departamentos = Departamento::orderBy('nome','asc')->get();
    	return view('departamentos.index')->with('departamentos', $departamentos);
    }
    
    public function create(){
    	return view('departamentos.create');
    }

	public function store(DepartamentoRequest $request){
		Departamento::create($request->all());
		session()->flash('info', 'Departamento inserido com sucesso!');
		return redirect('/departamentos');
	}

	public function edit($id){
		$departamento = Departamento::findOrFail($id);
		return view('departamentos.edit')->with('departamento', $departamento);
	}

	public function update(UpdateDepartamentoRequest $request, $id){
		$departamento = Departamento::findOrFail($id);
		$departamento->nome = $request->nome;
		$departamento->sigla = $request->sigla;

		$departamento->save();
		session()->flash('info', 'Departamento atualizado com sucesso!');
		return redirect('/departamentos');
	}

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
