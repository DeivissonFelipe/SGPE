<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'observacoes', 'tipo', 'turma_id', 'status', 'aprovacao', 
        'objetivo', 'metodologia', 'avaliacao'
    ];

    public function planejamentoAulas(){
    	return $this->hasMany('App\PlanejamentoAula')->orderBy('data', 'asc');
    }
    public function planejamentoUnidades(){
    	return $this->hasMany('App\PlanejamentoUnidade');
    }
    public function exames(){
    	return $this->hasMany('App\Exame')->orderBy('data', 'asc');
    }
    public function pendencias(){
        return $this->hasMany('App\Pendencia');
    }
    public function turma(){
        return $this->belongsTo('App\Turma');
    }

    public function getAprovacaoAttribute($value){
        if(isset($value)){
            return Carbon::parse($value)->format('d-m-Y');
        }
    }
    public static function esperando_analise(){
        return static::where('status','=','Em Análise')->count();
    }
    public static function planos_pendencia($turmas_user){
        return \App\Plano::whereIn('planos.turma_id', $turmas_user)
                    ->join('pendencias', 'pendencias.plano_id', '=', 'planos.id')
                    ->count();
    }
}
