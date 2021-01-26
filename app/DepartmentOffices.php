<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\DepartmentOffices
 *
 * @property int $id
 * @property int $user_id
 * @property int $department_category_id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $avatar
 * @property string $address
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\DepartmentCategories $department_categories
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentOffices onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereDepartmentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentOffices whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentOffices withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentOffices withoutTrashed()
 * @mixin \Eloquent
 */
class DepartmentOffices extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function department_categories(): BelongsTo
    {
        return $this->belongsTo(DepartmentCategories::class, 'department_category_id');
    }
}
