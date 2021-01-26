<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\BaranggayOfficial
 *
 * @property int $id
 * @property int $baranggay_id
 * @property string $name
 * @property string $position 1-kagawad|2-Captain|3-SK|4-Secretary|5-treasurer
 * @property int $from
 * @property int $to
 * @property string $status
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Baranggay $baranggay
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\BaranggayOfficial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereBaranggayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaranggayOfficial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaranggayOfficial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\BaranggayOfficial withoutTrashed()
 * @mixin \Eloquent
 */
class BaranggayOfficial extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function baranggay(): BelongsTo
    {
        return $this->belongsTo(Baranggay::class);
    }
}
