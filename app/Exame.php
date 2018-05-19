<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exame extends Model
{
    protected $fillable = [
    	'descricao', 'peso', 'data', 'conteudo', 'plano_id'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }

    public function getDataAttribute($value)
    {
         return Carbon::parse($value)->format('d-m-Y');
    }

}
