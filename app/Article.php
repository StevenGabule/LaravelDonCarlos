<?php

namespace App;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Article
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property int $category_id
 * @property int $status 0 - for draft | 1 - for pub.
 * @property string|null $avatar
 * @property int $important
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\ArticleCategory $category
 * @property-read mixed $created
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ArticleTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article filter($filter)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article latestFirst()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Article withoutTrashed()
 * @mixin \Eloquent
 */
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
        if (isset($filter['filter_by_year']) && $term = $filter['filter_by_year']) {
            $query->whereRaw('YEAR(created_at) = ?', $term);
        }
    }

    public function display_image(): string
    {
        return $this->avatar !== null ? $this->avatar : asset('assets/images/photo-1558449033-7ae045d2c81a.jfif');
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
