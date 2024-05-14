<?php

namespace App\Repository\Account;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class ViewerRepository
{
    public function getViewer(): Authenticatable|User|null
    {
        return Auth::user();
    }

    public function incrementViewerPostCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->posts_count += $count;
        $user->save();
    }

    public function decrementViewerPostCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->posts_count -= $count;
        $user->save();
    }

    public function incrementViewerMediaCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->media_count += $count;
        $user->save();
    }

    public function decrementViewerMediaCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->media_count -= $count;
        $user->save();
    }

    public function incrementViewerFavoritePostsCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->favorite_posts_count += $count;
        $user->save();
    }

    public function decrementViewerFavoritePostsCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->favorite_posts_count -= $count;
        $user->save();
    }

    public function incrementViewerMediaPostCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->media_posts_count += $count;
        $user->save();
    }

    public function decrementViewerMediaPostCount(int $count = 1): void
    {
        $user = $this->getViewer();
        $user->media_posts_count -= $count;
        $user->save();
    }

    public function incrementViewerLikedPostsCount(): void
    {
        $user = $this->getViewer();
        $user->liked_posts_count += 1;
        $user->save();
    }

    public function decrementViewerLikedPostsCount(): void
    {
        $user = $this->getViewer();
        $user->liked_posts_count -= 1;
        $user->save();
    }
}
