<?php

namespace App;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ArticleTag::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function display_data($value, $def)
    {
        if (strlen($value) <= $def) {
            return $value;
        }
        return substr($value, 0, $def) . '...';
    }

    public function getCreatedAttribute()
    {
        return $this->created_at->format('d M');
    }

    public function scopeFilter($query, $filter): void
    {
        if (isset($filter['q']) && $term = strtolower($filter['q'])) {
            $query->where(static function ($q) use ($term) {
                $q->orwhereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
                $q->orwhereRaw('LOWER(short_description) LIKE ?', ["%{$term}%"]);
                $q->orwhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
            });
        }
    }

    public function display_image(): string
    {
        return $this->avatar !== null ? "/backend/uploads/articles/large/$this->avatar" : 'https://images.unsplash.com/photo-1558449033-7ae045d2c81a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80';
    }
}
