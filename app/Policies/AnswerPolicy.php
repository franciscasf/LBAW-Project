<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;

class AnswerPolicy
{

        /**
     * Determine if the user can create an answer.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }


    /**
     * Determine if the user can view any answers.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true; // Qualquer user autenticado pode visualizar respostas
    }

    /**
     * Determine if the user can view a specific answer.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Answer  $answer
     * @return bool
     */
    public function view(?User $user, Answer $answer): bool
    {
        return true; // Qualquer pessoa (autenticada ou não) pode visualizar uma resposta
    }

    

    /**
     * Determine if the user can update an answer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return bool
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user->id === $answer->users->first()->id || $user->is_admin; // Apenas o autor da resposta ou qdmin pode editá-la
    }

    /**
     * Determine if the user can delete an answer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return bool
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === $answer->users->first()->id || $user->is_admin; // Autor ou admin podem apagar
    }


    /**
     * Determine if the user can permanently delete an answer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return bool
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return $user->is_admin; // Apenas admins podem excluir permanentemente respostas
    }
}
