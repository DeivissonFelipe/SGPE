<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Semestre extends Model
{
    protected $fillable = [
    	'rotulo', 'inicio', 'fim'
    ];

    protected $dates = ['inicio', 'fim'];

    public function feriados(){
    	return $this->hasMany('App\Feriado');
    }
    public function trocas(){
    	return $this->hasMany('App\Troca');
    }

    public function turmas(){
        return $this->hasMany('App\Turma');
    }

    public function getInicioAttribute($value)
    {
         return Carbon::parse($value)->format('d-m-Y');
    }

    public function getFimAttribute($value)
    {
         return Carbon::parse($value)->format('d-m-Y');
    }    
}
