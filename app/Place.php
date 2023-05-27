<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Place
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $categories
 * @property int $status 1-pub|2-unp
 * @property string $address
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Place onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Place withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Place withoutTrashed()
 * @mixin \Eloquent
 */
class Place extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

  public function display_image(): string
  {
    return $this->avatar !== null ? asset($this->avatar) : asset('assets/images/photo-1558449033-7ae045d2c81a.jfif');
  }

}
