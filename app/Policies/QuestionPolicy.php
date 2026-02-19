<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    /**
     * Determine if the user can view any questions.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true; // Qualquer usuário autenticado pode visualizar perguntas
    }

    /**
     * Determine if the user can view a specific question.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function view(?User $user, Question $question): bool
    {
        return true; // Qualquer pessoa (autenticada ou não) pode visualizar uma pergunta
    }

    
    /**
     * Determine if the user can update a question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function update(User $user, Question $question): bool
    {
        return $user->id === $question->author_id || $user->is_admin; // Apenas o autor da pergunta pode editá-la
    }

    /**
     * Determine if the user can delete a question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->id === $question->author_id || $user->is_admin; // Autor ou admin podem apagar
    }

    /**
     * Determine if the user can restore a deleted question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function restore(User $user, Question $question): bool
    {
        return $user->is_admin; // Apenas admins podem restaurar perguntas
    }

    /**
     * Determine if the user can permanently delete a question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return $user->is_admin; // Apenas admins podem apagar permanentemente
    }

    /**
     * Determine if the user can create a question.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

}
