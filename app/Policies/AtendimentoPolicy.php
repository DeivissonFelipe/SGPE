<?php

namespace App\Policies;

use App\User;
use App\Atendimento;
use App\Plano;
use Illuminate\Auth\Access\HandlesAuthorization;

class AtendimentoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create, update or delete the 'Atendimentos'.
     *
     * @param  \App\User  $user
     * @param  \App\Atendimento $atendimento
     * @return mixed
     */
    public function crud(User $user, Atendimento $atendimento)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pAtendimento = $atendimento->plano->turma_id;
        return in_array($pAtendimento, $pUser);
    }
}
