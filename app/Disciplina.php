<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
	protected $fillable = [
    	'codigo', 'nome', 'name', 'departamento_id', 'chsemestral',
        'chsemanalp', 'chsemanalt','ementa', 'conteudo','bibliografiab', 'bibliografiac'
	];

	public function departamento(){
		return $this->belongsTo('App\Departamento');
	}

	public function turmas(){
		return $this->hasMany('App\Turma');
	}

	public function cursos(){
        	return $this->belongsToMany('App\Curso', 'disciplina_curso', 'disciplina_id', 'curso_id');
	}
	
}
