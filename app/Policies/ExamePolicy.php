<?php

namespace App\Policies;

use App\User;
use App\Exame;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create, update or delete the 'Exame'.
     *
     * @param  \App\User  $user
     * @param  \App\Exame $exame
     * @return mixed
     */
    public function crud(User $user, Exame $exame){
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pExame = $exame->plano->turma_id;
        return in_array($pExame, $pUser);
    }
}
