<?php

namespace App\Models;

use App\Services\User\UserHelpers;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $profile_picture_filename
 * @property string $profile_banner_filename
 * @property string $bio
 * @property string $location
 * @property string $link
 * @property bool $following
 * @property int $posts_count
 * @property int $favourites_count
 * @property int $follows_count
 * @property int $followers_count
 * @property Collection $follows
 * @property Collection $followers
 * @property Date $birth
 * @property string $password
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @method static User create (array $attributes = [])
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'birth',
        'email_verified_at',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'email',
        'pivot',
        'email_verified_at',
        'updated_at',
        'password',
        'remember_token',
        'profile_picture_filename',
        'profile_banner_filename'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'profile_picture',
        'profile_banner',
        'following'
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username
        ];
    }

    public function getProfilePictureAttribute(): array
    {
        return UserHelpers::getProfilePicturePaths(
            id: $this->id,
            filename: $this->profile_picture_filename
        );
    }

    public function getProfileBannerAttribute(): array
    {
        return UserHelpers::getProfileBannerPaths(
            id: $this->id,
            filename: $this->profile_banner_filename
        );
    }

    public function getFollowingAttribute(): bool
    {
        return DB::table('follows')
            ->where('follower_id', Auth::id())
            ->where('follow_id', $this->id)
            ->exists();
    }

    public function posts(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            'id',
            'user_id'
        );
    }

    public function liked_posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'liked_posts',
            'user_id',
            'post_id',
        )->withTimestamps();
    }

    public function retweeted_posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'retweeted_posts',
            'user_id',
            'post_id',
        )->withTimestamps();
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follow_id',
            'follower_id',
        )->withTimestamps();
    }

    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'follow_id',
        )->withTimestamps();
    }
}
