<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlanejamentoUnidade extends Model
{
    protected $fillable = [
    	'unidade', 'hora_aula', 'descricao', 'plano_id'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }
}
