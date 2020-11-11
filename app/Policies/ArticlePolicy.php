<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Article destroy action policy.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if($user->id == 4)
            return true;
    }

    /**
     * Article destroy action policy.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function destroy(User $user, Article $article)
    {
        return $article->user->is($user);
    }
}
