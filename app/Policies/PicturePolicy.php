<?php

namespace App\Policies;

use App\User;
use App\Picture;
use Illuminate\Auth\Access\HandlesAuthorization;

class PicturePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Picture $picture)
    {
        return isAdmin($user);
    }
}
