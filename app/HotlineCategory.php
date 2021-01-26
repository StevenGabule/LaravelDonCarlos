<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HotlineCategory
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotlineCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotlineCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotlineCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotlineCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotlineCategory whereName($value)
 * @mixin \Eloquent
 */
class HotlineCategory extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
}
