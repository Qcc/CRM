<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Follow $follow)
    {
        return $user->isAuthorOf($follow);
    }

    public function destroy(User $user, Follow $follow)
    {
        return $user->isAuthorOf($follow);
    }
    public function manager(User $user, Follow $follow)
    {   
        return $user->can('manager');
    }
}
