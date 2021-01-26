<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\ArticleCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleCategory extends Model
{
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
