<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadImage {
  public function upload($model, $folderName)
  {
    $disk = $model->disk;
    $filename = $model->avatar;
    $original_file = storage_path() . "/uploads/".$folderName."/original/". $filename;

    try {
      // create the large image and save to tmp disk
      Image::make($original_file)->fit(800, 600, function ($constraint) {
        $constraint->aspectRatio();
      })->save($large = storage_path("uploads/".$folderName."/large/$filename"));

      // create the thumbnail image
      Image::make($original_file)->fit(250, 200, function ($constraint) {
        $constraint->aspectRatio();
      })->save($thumbnail = storage_path("uploads/".$folderName."/thumbnail/$filename"));

      // store images to permanent disk
      // original image
      if (Storage::disk($disk)->put("uploads/".$folderName."/original/$filename", fopen($original_file, 'r+'))) {
        File::delete($original_file);
      }

      // large image
      if (Storage::disk($disk)->put("uploads/".$folderName."/large/$filename", fopen($large, 'r+'))) {
        File::delete($large);
      }

      // thumbnail image
      if (Storage::disk($disk)->put("uploads/".$folderName."/thumbnail/$filename", fopen($thumbnail, 'r+'))) {
        File::delete($thumbnail);
      }

      // update the database record with success flag
      $model->update(['upload_successful' => true]);
    } catch (\Exception $e) {
      Log::error($e);
    }
  }
}
