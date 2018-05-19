<?php

namespace App\Policies;

use App\User;
use App\Turma;
use Illuminate\Auth\Access\HandlesAuthorization;

class TurmaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the turma.
     *
     * @param  \App\User  $user
     * @param  \App\Turma  $turma
     * @return mixed
     */
    public function owner(User $user, Turma $turma)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        return in_array($turma->id, $pUser);   
    }
}
