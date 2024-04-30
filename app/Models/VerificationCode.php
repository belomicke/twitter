<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string code
 * @property string email
 *
 * @method static VerificationCode create(array $attributes = [])
 */
class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
    ];
}
