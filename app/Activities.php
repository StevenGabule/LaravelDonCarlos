<?php

namespace App;

use DateTime;
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
        return date_parse($this->date_start)[$format];
    }

    public function make_date(): string
    {
        $hour = (int)DateTime::createFromFormat('Y-m-d H:i:s',$this->date_start)->format('H');
        if ($hour <= 12) {
            return DateTime::createFromFormat('Y-m-d H:i:s',$this->date_start)->format('H:i A');
        }

        $setHour = $hour - 12;
        return $setHour . ':'.DateTime::createFromFormat('Y-m-d H:i:s',$this->date_start)->format('i A');
    }
}
