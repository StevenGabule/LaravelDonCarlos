<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Hotline
 *
 * @property int $id
 * @property int $hotline_category_id
 * @property string $phone_number
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline whereHotlineCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotline wherePhoneNumber($value)
 * @mixin \Eloquent
 */
class Hotline extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function hotline_category()
    {
        return $this->belongsTo(HotlineCategory::class);
    }
}
