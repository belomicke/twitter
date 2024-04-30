<?php

namespace App\Repository\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowRepository
{
    public function exists(User $user): bool
    {
        return DB::table('follows')
            ->where('follower_id', Auth::id())
            ->where('follow_id', $user->id)
            ->where('is_deleted', false)
            ->exists();
    }

    public function follow(User $user): void
    {
        DB::table('follows')->insert([
            'follower_id' => Auth::id(),
            'follow_id' => $user->id,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }

    public function unfollow(User $user): void
    {
        DB::table('follows')
            ->where('follower_id', Auth::id())
            ->where('follow_id', $user->id)
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }
}
