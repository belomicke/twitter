<?php

namespace App\Providers;

use App\Policies\Post\CreateQuotePolicy;
use App\Policies\Post\Favorite\AddPostToFavoritePolicy;
use App\Policies\Post\Favorite\RemovePostFromFavoritePolicy;
use App\Policies\Post\Retweet\RetweetPostPolicy;
use App\Policies\Post\Retweet\UndoRetweetPostPolicy;
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

        Gate::define('add-post-to-favorite', AddPostToFavoritePolicy::class);
        Gate::define('remove-post-from-favorite', RemovePostFromFavoritePolicy::class);

        Gate::define('retweet-post', RetweetPostPolicy::class);
        Gate::define('undo-retweet-post', UndoRetweetPostPolicy::class);
    }
}
