<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ServicesArticle
 *
 * @property int $id
 * @property int $services_id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string|null $avatar
 * @property int $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Services $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle filter($filter)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesArticle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereServicesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServicesArticle whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesArticle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ServicesArticle withoutTrashed()
 * @mixin \Eloquent
 */
class ServicesArticle extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Services::class);
    }

    public function scopeFilter($query, $filter): void
    {
        if (isset($filter['q']) && $term = strtolower($filter['q'])) {
            $query->where(static function($q) use ($term) {
               $q->orwhereRaw('LOWER(name) LIKE ?', ["%{$term}%"]);
               $q->orwhereRaw('LOWER(short_description) LIKE ?', ["%{$term}%"]);
               $q->orwhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
            });
        }
    }

}
