<?php

namespace App;

use DateTime;
use Facade\FlareClient\Time\Time;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Activities
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $event_start
 * @property string|null $opening_time
 * @property string|null $closing_time
 * @property string $address
 * @property int $status 0-d|1|p
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $display_address
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Activities onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereClosingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereEventStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereOpeningTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activities whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activities withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Activities withoutTrashed()
 * @mixin \Eloquent
 */
class Activities extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function getDisplayAddressAttribute()
    {
        if (strlen($this->address) <= 55) {
            return $this->address;
        }
        return substr($this->address, 0, 55) . '...';
    }

    public function display_date($format)
    {
        return date_parse($this->event_start)[$format];
    }

    public function convert_date()
    {
        return DateTime::createFromFormat('Y-m-d', $this->event_start)->format('D, d M Y');
    }

    public function time_gap($time): string
    {
        $openingTime = (int)DateTime::createFromFormat('H:i:s', $time)->format('H');

        if ($openingTime <= 12) {
            return DateTime::createFromFormat('H:i:s', $time)->format('H:i A');
        }

        $openHour = $openingTime - 12;
        return $openHour . ':' . DateTime::createFromFormat('H:i:s', $time)->format('i A');
    }

    public function display_image(): string
    {
        return $this->avatar !== null ? $this->avatar : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80';
    }
}
