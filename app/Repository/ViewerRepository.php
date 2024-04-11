<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;

class ViewerRepository
{
    public function incrementViewerPostCount(): void
    {
        $user = Auth::user();
        $user->posts_count += 1;
        $user->save();
    }

    public function decrementViewerPostCount(): void
    {
        $user = Auth::user();
        $user->posts_count -= 1;
        $user->save();
    }

    public function incrementViewerFavoritePostsCount(): void
    {
        $user = Auth::user();
        $user->favorites_count += 1;
        $user->save();
    }

    public function decrementViewerFavoritePostsCount(): void
    {
        $user = Auth::user();
        $user->favorites_count -= 1;
        $user->save();
    }
}
