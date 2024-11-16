<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
