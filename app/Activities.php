<?php

namespace App;

use DateTime;
use Facade\FlareClient\Time\Time;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return DateTime::createFromFormat('Y-m-d H:i:s', $this->event_start)->format('D, d M Y');
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
}
