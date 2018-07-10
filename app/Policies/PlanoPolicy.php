<?php

namespace App\Policies;

use App\User;
use App\Plano;
use App\Turma;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the plano.
     *
     * @param  \App\User  $user
     * @param  \App\Plano  $plano
     * @return mixed
     */
    public function view(User $user, Plano $plano)
    {
        //
    }

    /**
     * Determine whether the user can create planos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the plano.
     *
     * @param  \App\User  $user
     * @param  \App\Plano  $plano
     * @return mixed
     */
    public function update(User $user, Plano $plano)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pTurma = $plano->turma_id;

        return in_array($pTurma, $pUser) && ($plano->status == 'Em Edição');
    }

    /**
     * Determine whether the user can delete the plano.
     *
     * @param  \App\User  $user
     * @param  \App\Plano  $plano
     * @return mixed
     */
    public function delete(User $user, Plano $plano)
    {
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pTurma = $plano->turma_id;

        return in_array($pTurma, $pUser) && ($plano->status == 'Em Edição');
    }
    
    /**
     * Determine whether the user can acess the plano.
     *
     * @param  \App\User  $user
     * @param  \App\Plano  $plano
     * @return mixed
     */
    public function owner(User $user, Plano $plano){
        $pUser = $user->turmas()->pluck('turma_id')->toArray();
        $pTurma = $plano->turma_id;

        return in_array($pTurma, $pUser);
    }
}
