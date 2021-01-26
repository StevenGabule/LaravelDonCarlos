<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transparency
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $short_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransparencyPost[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transparency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transparency extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(TransparencyPost::class, 'transparency_id');
    }
}
