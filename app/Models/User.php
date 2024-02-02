<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $profile_picture_path
 * @property string $profile_banner_path
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
        'profile_picture_path',
        'profile_banner_path'
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

    public function getProfilePictureAttribute(): string
    {
        $path = $this->profile_picture_path;

        return $path ? "/storage/$this->profile_picture_path" : '';
    }

    public function getProfileBannerAttribute(): string
    {
        $path = $this->profile_banner_path;

        return $path ? "/storage/$this->profile_banner_path" : '';
    }
}
