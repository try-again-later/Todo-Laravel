<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    public function show(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    public function update(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }
}
