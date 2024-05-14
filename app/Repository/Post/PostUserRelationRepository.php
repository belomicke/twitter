<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostUserRelationRepository
{
    protected string $table = '';

    public function add(int $id): void
    {
        DB::table($this->table)
            ->insert([
                'post_id' => $id,
                'user_id' => Auth::id(),
                'is_deleted' => false,
                'updated_at' => now(),
                'created_at' => now()
            ]);
    }

    public function remove(int $id): void
    {
        DB::table($this->table)
            ->where('post_id', $id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }

    public function getStatusById(int $id): bool
    {
        return DB::table($this->table)
            ->where('post_id', $id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->exists();
    }

    public function getStatus(Post $post): bool
    {
        return DB::table($this->table)
            ->where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->exists();
    }

    public function getMultipleStatuses(array $ids): Collection
    {
        return DB::table($this->table)
            ->whereIn('post_id', $ids)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->get();
    }
}
