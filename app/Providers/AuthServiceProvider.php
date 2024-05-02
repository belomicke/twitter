<?php

namespace App\Providers;

use App\Policies\Post\CreateQuotePolicy;
use App\Policies\Post\EditPostPolicy;
use App\Policies\Post\Like\LikePostPolicy;
use App\Policies\Post\Like\UnlikePostPolicy;
use App\Policies\Post\Retweet\RetweetPostPolicy;
use App\Policies\Post\Retweet\UndoRetweetPostPolicy;
use App\Policies\User\Follows\FollowUserPolicy;
use App\Policies\User\Follows\UnfollowUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-quote', CreateQuotePolicy::class);
        Gate::define('edit-post', EditPostPolicy::class);

        Gate::define('like-post', LikePostPolicy::class);
        Gate::define('unlike-post', UnlikePostPolicy::class);

        Gate::define('retweet-post', RetweetPostPolicy::class);
        Gate::define('undo-retweet-post', UndoRetweetPostPolicy::class);

        Gate::define('follow-user', FollowUserPolicy::class);
        Gate::define('unfollow-user', UnfollowUserPolicy::class);
    }
}
