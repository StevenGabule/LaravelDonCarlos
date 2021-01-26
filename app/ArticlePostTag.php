<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ArticlePostTag
 *
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArticlePostTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticlePostTag extends Model
{
    //
}
