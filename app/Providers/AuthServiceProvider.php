<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Plano' => 'App\Policies\PlanoPolicy',
        'App\Exame' => 'App\Policies\ExamePolicy',
        'App\Horario' => 'App\Policies\HorarioPolicy',
        'App\PlanejamentoAula' => 'App\Policies\PlanejamentoAPolicy',
        'App\PlanejamentoUnidade' => 'App\Policies\PlanejamentoUPolicy',
        'App\Turma' => 'App\Policies\TurmaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
