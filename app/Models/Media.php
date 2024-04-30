<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int post_id
 * @property string filename
 * @property int width
 * @property int height
 * @property string mime_type
 */
class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'filename',
        'width',
        'height',
        'mime_type',
        'type'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'path'
    ];

    public function getPathAttribute(): string
    {
        return 'storage/images/' . $this->filename;
    }
}
