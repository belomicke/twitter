<?php

namespace App\Models;

use App\Services\User\UserHelpers;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\HasApiTokens;

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
 * @property int $posts_count
 * @property int $follows_count
 * @property int $followers_count
 * @property Date $birth
 * @property string $password
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @method static User create (array $attributes = [])
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'profile_banner'
    ];

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

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'id', 'user_id');
    }
}
