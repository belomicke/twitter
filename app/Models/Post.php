<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @property int $user_id
 *
 * @method static Post create (array $attributes = [])
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
