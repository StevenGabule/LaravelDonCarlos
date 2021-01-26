<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\TransparentPostFile
 *
 * @property int $id
 * @property int $transparency_post_id
 * @property int $transparency_file_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\TransparencyPost $transparency_post
 * @property-read \App\TransparencyFile $transparent_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile whereTransparencyFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile whereTransparencyPostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparentPostFile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransparentPostFile extends Model
{
    protected $guarded = [];

    public function transparency_post() : BelongsTo
    {
        return $this->belongsTo(TransparencyPost::class);
    }

    public function transparent_file(): BelongsTo
    {
        return $this->belongsTo(TransparencyFile::class, 'transparency_file_id');
    }
}
