<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Feriado extends Model
{
    protected $fillable = [
    	'data', 'semestre_id'
    ];

    protected $dates = ['data'];

    public function semestre(){
    	return $this->belongsTo('App\Semestre');
    }

    public function getDataAttribute($value)
    {
         return Carbon::parse($value)->format('d-m-Y');
    }

    // public function setDataAttribute($value){
    //     $this->attributes['data'] = Carbon::createFromFormat('Y-m-d', $value);
    // }
}
