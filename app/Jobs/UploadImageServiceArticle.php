<?php

namespace App\Jobs;

use App\ServicesArticle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImageServiceArticle implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $id;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($id)
  {
    $this->id = $id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $sa = ServicesArticle::where('id', $this->id)->first();
    $disk = $sa->disk;
    $filename = $sa->avatar;
    $original_file = storage_path() . '/uploads/services_article/original/' . $filename;

    try {
      // create the large image and save to tmp disk
      Image::make($original_file)->fit(800, 600, function ($constraint) {
        $constraint->aspectRatio();
      })->save($large = storage_path('uploads/services_article/large/' . $filename));

      // create the thumbnail image
      Image::make($original_file)->fit(250, 200, function ($constraint) {
        $constraint->aspectRatio();
      })->save($thumbnail = storage_path('uploads/services_article/thumbnail/' . $filename));

      // store images to permanent disk
      // original image
      if (Storage::disk($disk)->put("uploads/services_article/original/$filename", fopen($original_file, 'r+'))) {
        File::delete($original_file);
      }

      // large image
      if (Storage::disk($disk)->put("uploads/services_article/large/$filename", fopen($large, 'r+'))) {
        File::delete($large);
      }

      // thumbnail image
      if (Storage::disk($disk)->put("uploads/services_article/thumbnail/$filename", fopen($thumbnail, 'r+'))) {
        File::delete($thumbnail);
      }

      // update the database record with success flag
      $sa->update(['upload_successful' => true]);
    } catch (\Exception $e) {
      Log::error($e);
    }
  }
}
