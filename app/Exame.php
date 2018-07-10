<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exame extends Model
{
    protected $fillable = [
    	'descricao', 'peso', 'data', 'conteudo', 'plano_id'
    ];

    protected $dates = ['data'];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }

    public function getDataAttribute($value)
    {
         return ($value == null) ? null : Carbon::parse($value)->format('d-m-Y');
    }

}
