<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the authenticated user can view the given user's profile.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $targetUser
     * @return bool
     */
    public function view(User $authUser, User $targetUser)
    {
        // Allow viewing if the user is viewing their own profile or if there's no restriction on profile visibility.
        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine if the authenticated user can update their own profile.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $targetUser
     * @return bool
     */
    public function update(User $authUser, User $targetUser)
    {
        // Only allow updating the profile if it's the user's own profile.
        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine if the authenticated user can delete their own account.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $targetUser
     * @return bool
     */
    public function delete(User $authUser, User $targetUser)
    {
        // Only allow deleting if it's the user's own account.
        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine if the authenticated user can manage other users (admin action).
     *
     * @param  \App\Models\User  $authUser
     * @return bool
     */
    public function manage(User $authUser)
    {
        // Allow only admins to manage other users.
        return $authUser->is_admin;
    }

    
}
