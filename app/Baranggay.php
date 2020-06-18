<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baranggay extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

   /* public function baranggay_officials(): HasMany
    {
        return $this->hasMany(BaranggayOfficial::class);
    }*/
}
