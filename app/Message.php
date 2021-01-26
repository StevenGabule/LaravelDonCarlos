<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Message
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string|null $to
 * @property string $subject
 * @property string $email
 * @property string $message
 * @property int $status 0-unread|1-read|2-sent
 * @property int $label
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Message onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Message withoutTrashed()
 * @mixin \Eloquent
 */
class Message extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
