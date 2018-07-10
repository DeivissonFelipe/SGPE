<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlanejamentoAula extends Model
{
    protected $fillable = [
    	'aula', 'tipo', 'data', 'conteudo', 'plano_id'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }

    public function getDataAttribute($value)
    {
        return ($value == null) ? null : Carbon::parse($value)->format('d-m-Y');
    }
}
