<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'observacoes', 'tipo', 'turma_id', 'status', 'aprovacao', 'ementa', 'conteudo',
        'objetivo', 'metodologia', 'bibliografiab', 'bibliografiac', 'avaliacao'
    ];

    public function atendimentos(){
    	return $this->hasMany('App\Atendimento');
    }
    public function planejamentoAulas(){
    	return $this->hasMany('App\PlanejamentoAula')->orderBy('data', 'asc');
    }
    public function planejamentoUnidades(){
    	return $this->hasMany('App\PlanejamentoUnidade');
    }
    public function horarios(){
    	return $this->hasMany('App\Horario');
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

    public function getAprovacaoAttribute($value)
    {
        if(isset($value)){
            return Carbon::parse($value)->format('d-m-Y');
        }
    }
}
