<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\ArticleTag
 *
 * @property int $id
 * @property string $tag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticleTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleTag extends Model
{
    protected $guarded = [];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
