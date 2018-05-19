<?php

namespace App\Policies;

use App\User;
use App\Horario;
use Illuminate\Auth\Access\HandlesAuthorization;

class HorarioPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can create, update or delete the 'Horario'.
     *
     * @param  \App\User  $user
     * @param  \App\Horario $horario
     * @return mixed
     */
    public function crud(User $user, Horario $horario)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pHorario = $horario->plano->turma_id;
        return in_array($pHorario, $pUser);
    }
}
