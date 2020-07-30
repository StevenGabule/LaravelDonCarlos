<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransparencyPost extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function transparency(): BelongsTo
    {
        return $this->belongsTo(Transparency::class);
    }

    public function scopeFilter($query, $filter) : void
    {
        if (isset($filter['q']) && $term = strtolower($filter['q'])) {
            $query->where(static function($q) use ($term) {
                $q->orwhereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
                $q->orwhereRaw('LOWER(short_description) LIKE ?', ["%{$term}%"]);
                $q->orwhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
            });
        }
    }

    public function transparencies(): BelongsTo
    {
        return $this->belongsTo(Transparency::class, 'transparency_id');
    }

    public function transparency_post_files(): HasMany
    {
        return $this->hasMany(TransparentPostFile::class);
    }
}
