<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function edit(User $user, User $currentUser)
    {
        return $user->id == $currentUser->id;
    }
}
