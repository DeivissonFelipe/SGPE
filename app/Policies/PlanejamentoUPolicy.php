<?php

namespace App\Policies;

use App\User;
use App\PlanejamentoUnidade;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanejamentoUPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create, update or delete the 'PlanejamentoUnidade'.
     *
     * @param  \App\User  $user
     * @param  \App\PlanejamentoUnidade $pUnid
     * @return mixed
     */
    public function crud(User $user, PlanejamentoUnidade $pUnid)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $planU = $pUnid->plano->turma_id;
        return in_array($planU, $pUser) && ($pUnid->plano->status == "Em Edição");
    }
}
