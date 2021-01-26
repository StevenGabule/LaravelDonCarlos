<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\TransparencyPost
 *
 * @property int $id
 * @property int $user_id
 * @property int $transparency_id
 * @property string $title
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $description
 * @property int $views
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Transparency $transparencies
 * @property-read \App\Transparency $transparency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransparentPostFile[] $transparency_post_files
 * @property-read int|null $transparency_post_files_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost filter($filter)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\TransparencyPost onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereTransparencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyPost whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransparencyPost withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TransparencyPost withoutTrashed()
 * @mixin \Eloquent
 */
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
