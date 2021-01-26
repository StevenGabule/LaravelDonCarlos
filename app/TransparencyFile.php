<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;

/**
 * App\TransparencyFile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $filename
 * @property string|null $size
 * @property string|null $type
 * @property string|null $file_url
 * @property int $clicked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereClicked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransparencyFile whereUserId($value)
 * @mixin \Eloquent
 */
class TransparencyFile extends Model
{
    protected $guarded = [];

    public function urlDownload()
    {
        $arr = explode('/', $this->file_url);
        $splits = explode('/', $this->file_url)[7];
        $publicId = explode('.', $splits)[0];
        $arr1 = [
            'name' => $this->name,
            'prefix' => 'don-carlos',
            'publicId' => $publicId,
        ];
        return "https://res.cloudinary.com/johnlook/image/upload/v1596048234/{$publicId}.{$this->type}";
//        return Cloudder::downloadArchiveUrl($arr1, null);
    }
}
