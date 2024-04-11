<?php

namespace App\Models;

use App\Helpers\PostHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $retweeted_post_id
 * @property int $favorite_count
 * @property int $retweet_count
 * @property int $reply_count
 *
 * @property int $in_reply_to_post_id
 * @property int $in_reply_to_user_id
 * @property string $in_reply_to_username
 *
 * @property bool $is_deleted
 *
 * @property Collection $likers
 *
 * @method static Post create (array $attributes = [])
 */
class Post extends Model
{
    use HasFactory, Searchable, HasRecursiveRelationships;

    public function getParentKeyName(): string
    {
        return 'in_reply_to_post_id';
    }

    public function getLocalKeyName(): string
    {
        return 'id';
    }

    protected $fillable = [
        'text',
        'user_id',
        'retweeted_post_id',
        'is_quote',
        'in_reply_to_post_id',
        'in_reply_to_user_id'
    ];

    protected $hidden = [
        'pivot',
        'is_deleted'
    ];

    protected $appends = [
        'favorited',
        'retweeted'
    ];

    protected $casts = [
        'is_quote' => 'boolean'
    ];

    protected static function booted(): void
    {
        static::creating(function ($post) {
            $post->text = PostHelpers::formatText(text: $post->text);
        });

        static::updating(function ($post) {
            $key = 'post:' . $post->id;

            Cache::forget($key);
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'text' => $this->text
        ];
    }

    public function getFavoritedAttribute(): bool
    {
        return DB::table('favorited_posts')
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
            'favorited_posts',
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

    public function commented_post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            'in_reply_to_post_id',
            'id',
        );
    }
}
