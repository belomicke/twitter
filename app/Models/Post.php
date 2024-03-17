<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $retweeted_post_id
 * @property int $likes_count
 * @property int $retweets_count
 *
 * @property Collection $likers
 *
 * @method static Post create (array $attributes = [])
 */
class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'text',
        'user_id',
        'retweeted_post_id'
    ];

    protected $hidden = [
        'pivot',
        'is_deleted'
    ];

    protected $appends = [
        'liked',
        'retweeted'
    ];

    public function toSearchableArray(): array
    {
        return [
            'text' => $this->text
        ];
    }

    public function getLikedAttribute(): bool
    {
        return DB::table('liked_posts')
            ->where('post_id', $this->id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->exists();
    }

    public function getRetweetedAttribute(): bool
    {
        return DB::table('posts')
            ->where('retweeted_post_id', $this->id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->where('text', '=', '')
            ->exists();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'liked_posts',
            'post_id',
            'user_id',
        )
            ->wherePivot('is_deleted', false)
            ->withTimestamps();
    }

    public function retweet(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            'retweeted_post_id',
            'id',
        );
    }
}
