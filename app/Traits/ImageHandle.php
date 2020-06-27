<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImageHandle
{

    public function removeImages($image, $model): void
    {
        $thumbnailPath = public_path() . "/backend/uploads/$model/thumbnail/$image";
        $largePath = public_path() . "/backend/uploads/$model/large/$image";
        $originalPath = public_path() . "/backend/uploads/$model/original/$image";
        $avatarPath = public_path() . "/backend/uploads/$model/small/$image";
        if (File::exists($thumbnailPath)) File::delete($thumbnailPath);
        if (File::exists($largePath)) File::delete($largePath);
        if (File::exists($avatarPath)) File::delete($avatarPath);
        if (File::exists($originalPath)) File::delete($originalPath);
    }

    public function uploadImages($old, $image, $name, $model)
    {
        $thumbnailImage = Image::make($image);
        $thumbnailPath = public_path() . "/backend/uploads/$model/thumbnail/";
        $largePath = public_path() . "/backend/uploads/$model/large/";
        $originalPath = public_path() . "/backend/uploads/$model/original/";
        $avatarPath = public_path() . "/backend/uploads/$model/small/";

        if ($old !== null) {
            $this->removeImages($old, $model);
        }

        $thumbnailImage->save($originalPath . $name);
        $thumbnailImage->resize(1920, 1280)->save($largePath . $name);
        $thumbnailImage->fit(288, 150)->save($thumbnailPath . $name);
        $thumbnailImage->fit(32, 32)->save($avatarPath . $name);
    }
}
