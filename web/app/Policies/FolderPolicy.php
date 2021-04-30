<?php

namespace App\Policies;

use App\Folder;
use App\User;

class FolderPolicy
{
    public function view(User $user, Folder $folder): bool
    {
        return $user->id === $folder->user_id;
    }
}
