<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransparentPostFile extends Model
{
    protected $guarded = [];

    public function transparency_post() : BelongsTo
    {
        return $this->belongsTo(TransparencyPost::class);
    }

    public function transparent_file(): BelongsTo
    {
        return $this->belongsTo(TransparencyFile::class, 'transparency_file_id');
    }
}
