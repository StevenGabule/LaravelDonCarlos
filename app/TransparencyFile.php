<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;

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
