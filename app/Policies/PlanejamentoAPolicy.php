<?php

namespace App\Policies;

use App\User;
use App\PlanejamentoAula;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanejamentoAPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create, update or delete the 'PlanejamentoAula'.
     *
     * @param  \App\User  $user
     * @param  \App\PlanejamentoAula $pAula
     * @return mixed
     */
    public function crud(User $user, PlanejamentoAula $pAula)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $planA = $pAula->plano->turma_id;
        return in_array($planA, $pUser);
    }
}
