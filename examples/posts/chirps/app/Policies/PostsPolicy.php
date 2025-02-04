<?php

namespace App\Policies;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostsPolicy
{
    /**
     * Determine whether the user can update and/or destroy the post.
     */
    public function adjust(User $user, Posts $post): Response
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('The user who wants to edit the post is not the author, operation denied!');
    }
}
