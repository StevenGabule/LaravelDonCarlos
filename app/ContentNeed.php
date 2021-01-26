<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ContentNeed
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string|null $avatar
 * @property int $need_type 1-award|2-mandate
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed filter($filter)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ContentNeed onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereNeedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentNeed whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContentNeed withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ContentNeed withoutTrashed()
 * @mixin \Eloquent
 */
class ContentNeed extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
}
