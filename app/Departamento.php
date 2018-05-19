<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
    	'sigla','nome'
    ];

    public function disciplinas(){
    	return $this->hasMany('App\Disciplina');
    }
}
