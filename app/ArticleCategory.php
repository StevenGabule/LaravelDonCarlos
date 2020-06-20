<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
