<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
    	'dia', 'inicio', 'fim', 'plano_id'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }
}
