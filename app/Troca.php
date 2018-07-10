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
    
    public static function getSub_Number($value){
        $dia = \DB::table('trocas')->where('dia', '=', $value)->select('substituicao')->first();
        switch ($dia->substituicao) {
            case 'Segunda-Feira':
                $numero = '1';
            break;
            case 'Terça-Feira':
                $numero = '2';
            break;
            case 'Quarta-Feira':
                $numero = '3';
            break;
            case 'Quinta-Feira':
                $numero = '4';
            break;
            case 'Sexta-Feira':
                $numero = '5';
            break;
            default:
                $numero = '0';
            break;
        }
        

        return $numero;
    }

}
