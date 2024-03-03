<?php

namespace App\Services\Post;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function like(Post $post): bool
    {
        $viewer = Auth::user();

        try {
            DB::table('liked_posts')
                ->where('post_id', $post->id)
                ->where('user_id', $viewer->id)
                ->updateOrInsert([
                    'post_id' => $post->id,
                    'user_id' => $viewer->id,
                    'is_deleted' => false,
                    'updated_at' => now(),
                    'created_at' => now()
                ]);
            $post->likes_count += 1;
            $post->save();

            $viewer->favourites_count += 1;
            $viewer->save();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function unlike(Post $post): bool
    {
        $viewer = Auth::user();

        try {
            DB::table('liked_posts')
                ->where('post_id', $post->id)
                ->where('user_id', $viewer->id)
                ->update([
                    'is_deleted' => true,
                    'updated_at' => now()
                ]);

            $post->likes_count -= 1;
            $post->save();

            $viewer->favourites_count -= 1;
            $viewer->save();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
