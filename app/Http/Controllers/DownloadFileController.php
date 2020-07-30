<?php

namespace App\Http\Controllers;

use App\TransparencyFile;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class DownloadFileController extends Controller
{
    public function download($id)
    {
        /*https://res.cloudinary.com/johnlook/image/upload/v1596048237/tvhu6vszbkoijbimyn52.pdf*/
        $file = TransparencyFile::findOrFail($id);
        $arr = explode('/', $file->file_url);
        $splits = explode('/', $file->file_url)[7];
        $publicId = explode('.', $splits)[0];
        $arr1 = [
            'name' => $file->name,
            'prefix' => 'don-carlos',
            'publicId' => $publicId,
        ];
        Cloudder::show($publicId);
        echo "$publicId";
    }
}
