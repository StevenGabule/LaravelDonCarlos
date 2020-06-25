<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transparency extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(TransparencyPost::class, 'transparency_id');
    }
}
