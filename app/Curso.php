<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
   	protected $fillable = ['nome', 'sigla'];

	public function turmas(){
    	return $this->hasMany('App\Turma');
	}
	
	public function disciplinas(){
        return $this->belongsToMany('App\Disciplina', 'disciplina_curso', 'curso_id', 'disciplina_id');
    }
}
