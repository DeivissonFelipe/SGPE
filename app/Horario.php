<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
    	'dia', 'turma_id'
    ];

    public function turma(){
    	return $this->belongsTo('App\Turma');
    }
}
