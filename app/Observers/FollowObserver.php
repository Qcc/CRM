<?php

namespace App\Observers;

use App\Models\Follow;

class FollowObserver
{
    public function saving(Follow $follow)
    {
        $follow->difficulties = clean($follow->difficulties, 'user_common_body');
    }
}
