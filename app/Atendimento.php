<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
    	'dia', 'inicio', 'fim', 'sala', 'plano_id'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }
}
