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

    public function incrementViewerPostCount(): void
    {
        $user = Auth::user();
        $user->posts_count += 1;
        $user->save();
    }

    public function decrementViewerPostCount(?int $count): void
    {
        $user = Auth::user();
        $user->posts_count -= $count !== null ? $count : 1;
        $user->save();
    }

    public function incrementViewerLikedPostsCount(): void
    {
        $user = Auth::user();
        $user->liked_posts_count += 1;
        $user->save();
    }

    public function decrementViewerLikedPostsCount(): void
    {
        $user = Auth::user();
        $user->liked_posts_count -= 1;
        $user->save();
    }
}
