<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('pertence', function ($attribute, $value, $parameters, $validator) {

            $semestre_id = array_get($validator->getData(), $parameters[0], null);
            $inicio = \Carbon\Carbon::parse(\App\Semestre::find($semestre_id)->inicio);
            $fim = \Carbon\Carbon::parse(\App\Semestre::find($semestre_id)->fim);
            $data = \Carbon\Carbon::parse($value);
            
            return ($data >= $inicio && $data <= $fim);
        });

        Validator::extend('pertence_plano', function ($attribute, $value, $parameters, $validator) {
            $plano_id = array_get($validator->getData(), $parameters[0], null);
            $semestre_id = \App\Plano::find($plano_id)->turma()->first()->semestre_id;
                    
            $inicio = \Carbon\Carbon::parse(\App\Semestre::find($semestre_id)->inicio);
            $fim = \Carbon\Carbon::parse(\App\Semestre::find($semestre_id)->fim);
            $data = \Carbon\Carbon::parse($value);
            
            return ($data >= $inicio && $data <= $fim);
        });

        Validator::extend('dia_semana', function ($attribute, $value, $parameters, $validator) {
            $data = \Carbon\Carbon::parse($value);            
            return !$data->isSunday();
        });

        Validator::extend('dia_distinto', function ($attribute, $value, $parameters, $validator) {
            $data = \Carbon\Carbon::parse($value);            
            $substituicao = array_get($validator->getData(), $parameters[0], null);
            switch ($substituicao) {
                case 'Segunda-Feira':
                    $teste = $data->isMonday();
                break;
                case'Terça-Feira':
                    $teste = $data->isTuesday();   
                break;
                case'Quarta-Feira':
                    $teste = $data->isWednesday();
                break;
                case'Quinta-Feira':
                    $teste = $data->isThursday();
                break;
                case'Sexta-Feira':
                    $teste = $data->isFriday();
                break;
                
            }
            return (!$teste);
        });

        Validator::extend('not_exists', function($attribute, $value, $parameters){
            return \DB::table($parameters[0])
                ->where($parameters[1], '=', $value)
                ->count()<1;
        });
        
        Validator::extend('valid_time', function($attribute, $value, $parameters){
            $tempo = explode(":", $value);
            $hora = $tempo[0];
            $minuto = $tempo[1];
            
            return ($hora >= 0 && $hora <= 24 && $minuto >= 0 && $minuto < 60);
        });

        Validator::extend('nao_ofertada', function($attribute, $value, $parameters, $validator){
            $curso_id = array_get($validator->getData(), $parameters[0], null);

            return \DB::table('disciplina_curso')
                        ->where('disciplina_id', '=', $value)
                        ->where('curso_id', '=', $curso_id)
                        ->count()>=1;

        });

        Validator::extend('mais100', function($attribute, $value, $parameters, $validator){
            $plano_id = array_get($validator->getData(), $parameters[0], null);
            $exames = \App\Plano::find($plano_id)->exames()->get();
            $soma =0;
            foreach ($exames as $e) {
                $soma+= $e->peso;
            }
            return ($soma + $value <= 100);
        });

        Validator::extend('campo_unico', function($attribute, $value, $parameters, $validator){
            $plano_id = array_get($validator->getData(), $parameters[2], null);
                return \DB::table($parameters[0])    
                    ->where($parameters[1], '=', $value)
                    ->where('plano_id', '=', $plano_id)
                    ->count()<1;
        });

        Validator::extend('dia_n_lecionado', function($attribute, $value, $parameters, $validator){
            $plano_id = array_get($validator->getData(), $parameters[0], null);
            $turma_id = \App\Plano::find($plano_id)->turma()->first()->id;
            $horarios = \App\Turma::find($turma_id)->horarios()->get();
        
            $dia_semana = date('w', strtotime($value));
            $dias_numero = array();
            foreach ($horarios as $key => $h) {
                array_push($dias_numero, $h->dia);
            }
            return in_array($dia_semana, $dias_numero);
        });

        Validator::extend('qtdAula', function($attribute, $value, $parameters, $validator){
            $chsemestral= array_get($validator->getData(), $parameters[0], null);
            $chsemanalt = array_get($validator->getData(), $parameters[1], null);
            $resultado = $value + $chsemanalt;
            if($chsemestral == 60){
                return ($resultado == 4);
            }else{
                return ($resultado == 2);
            }
        });

        view()->composer('layouts.sidebar', function($view){
            $user = \App\User::find(auth()->id());
            $turmas_user = $user->turmas()->pluck('turma_id')->toArray();
            $view->with('qtdPlanPend', \App\Plano::planos_pendencia($turmas_user));
            $view->with('qtdPlanAnalise', \App\Plano::esperando_analise());
        });

    
        Validator::extend('carga_horaria', function($attribute, $value, $parameters, $validator){
            $disciplina_id = array_get($validator->getData(), $parameters[0], null);
            $chsemestral = \App\Disciplina::find($disciplina_id)->chsemestral;
            if($chsemestral == 60){
                return (count($value) == 2);
            }else{
                return (count($value) == 1);
            }
        });

        Validator::extend('interjacente_inicio', function($attribute, $value, $parameters, $validator){
            $inicio = Carbon::createFromFormat('Y-m-d', $value);
            $semestres = \App\Semestre::all();
            foreach ($semestres as $key => $s) {
                $sInicio = Carbon::createFromFormat('d-m-Y', $s->inicio);
                $sFim = Carbon::createFromFormat('d-m-Y', $s->fim);
                if($inicio->between($sInicio, $sFim)){
                    return false;
                }
            }
            return true;
        });

        Validator::extend('interjacente_fim', function($attribute, $value, $parameters, $validator){
            $fim  = Carbon::createFromFormat('Y-m-d', $value);
            $semestres = \App\Semestre::all();
            foreach ($semestres as $key => $s) {
                $sInicio = Carbon::createFromFormat('d-m-Y', $s->inicio);
                $sFim = Carbon::createFromFormat('d-m-Y', $s->fim);
                if($fim->between($sInicio, $sFim)){
                    return false;
                }
            }
            return true;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
