<?php

namespace App\Models;

use App\Services\Post\PostHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @property int id
 * @property string text
 * @property int user_id
 * @property int retweeted_post_id
 * @property int media_count
 * @property int like_count
 * @property int retweet_count
 * @property int reply_count
 *
 * @property bool liked
 * @property bool retweeted
 *
 * @property int in_reply_to_post_id
 * @property int in_reply_to_user_id
 * @property string in_reply_to_username
 *
 * @property bool is_deleted
 * @property bool is_pinned
 * @property Collection likers
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
        'in_reply_to_user_id',
        'media_count',
        'is_pined',
        'is_deleted'
    ];

    protected $hidden = [
        'pivot',
        'is_deleted'
    ];

    protected $casts = [
        'is_quote' => 'boolean',
        'is_pinned' => 'boolean'
    ];

    protected static function booted(): void
    {
        static::creating(function ($post) {
            $post->text = PostHelpers::formatText(text: $post->text);
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'text' => $this->text
        ];
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

    public function replies(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            'id',
            'in_reply_to_post_id',
        )
            ->where('is_deleted', false);
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
