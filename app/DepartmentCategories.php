<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DepartmentCategories
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DepartmentCategories extends Model
{
    protected $guarded = [];
}
