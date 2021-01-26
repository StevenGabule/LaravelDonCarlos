<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Baranggay
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $population
 * @property string $address
 * @property string|null $avatar
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BaranggayOfficial[] $baranggay_officials
 * @property-read int|null $baranggay_officials_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay filter($filter)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Baranggay onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Baranggay whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Baranggay withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Baranggay withoutTrashed()
 * @mixin \Eloquent
 */
class Baranggay extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function baranggay_officials(): HasMany
    {
        $dt = Carbon::now();
        return $this->hasMany(BaranggayOfficial::class)->whereBetween('from', [$dt->year, $dt->year+1]);
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
