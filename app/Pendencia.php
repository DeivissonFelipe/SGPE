<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendencia extends Model
{
     protected $fillable = [
        'plano_id', 'pendencia'
    ];

    public function plano(){
    	return $this->belongsTo('App\Plano');
    }
}
