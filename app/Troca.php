<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Troca extends Model
{
    protected $fillable = [
    	'dia', 'substituicao', 'semestre_id'
    ];

    protected $dates = ['dia'];

    public function semestre(){
    	return $this->belongsTo('App\Semestre');
    }

    public function getDiaAttribute($value)
    {
         return Carbon::parse($value)->format('d-m-Y');
    }
    
}
