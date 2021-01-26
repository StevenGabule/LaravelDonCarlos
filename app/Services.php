<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Services
 *
 * @property int $id
 * @property string $name
 * @property string|null $short_description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicesArticle[] $category
 * @property-read int|null $category_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Services onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Services withoutTrashed()
 * @mixin \Eloquent
 */
class Services extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category(): hasMany
    {
        return $this->hasMany(ServicesArticle::class);
    }
}
