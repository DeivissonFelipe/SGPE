<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = [
        'disciplina_id', 'semestre_id', 'curso_id', 'tipo_turma', 'numero_turma'
    ];

    public function users(){
        return $this->belongsToMany('App\User', 'user_turma', 'turma_id', 'user_id');
    }
    
    public function semestre(){
    	return $this->belongsTo('App\Semestre');
    }
    public function curso(){
    	return $this->belongsTo('App\Curso');
    }
    public function disciplina(){
    	return $this->belongsTo('App\Disciplina');
    }
    
    public function planos(){
    	return $this->hasMany('App\Plano');
    }   
}
