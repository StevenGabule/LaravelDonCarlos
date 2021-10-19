<?php

namespace App\Jobs;

use App\Activities;
use App\DepartmentOffices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImageDepartmentOffice implements ShouldQueue
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
      $do = DepartmentOffices::where('id', $this->id)->first();
      $disk = $do->disk;
      $filename = $do->avatar;
      $original_file = storage_path() . '/uploads/department_offices/original/' . $filename;

      try {
        // create the large image and save to tmp disk
        Image::make($original_file)->fit(800, 600, function ($constraint) {
          $constraint->aspectRatio();
        })->save($large = storage_path('uploads/department_offices/large/' . $filename));

        // create the thumbnail image
        Image::make($original_file)->fit(250, 200, function ($constraint) {
          $constraint->aspectRatio();
        })->save($thumbnail = storage_path('uploads/department_offices/thumbnail/' . $filename));

        // store images to permanent disk
        // original image
        if (Storage::disk($disk)->put("uploads/department_offices/original/$filename", fopen($original_file, 'r+'))) {
          File::delete($original_file);
        }

        // large image
        if (Storage::disk($disk)->put("uploads/department_offices/large/$filename", fopen($large, 'r+'))) {
          File::delete($large);
        }

        // thumbnail image
        if (Storage::disk($disk)->put("uploads/department_offices/thumbnail/$filename", fopen($thumbnail, 'r+'))) {
          File::delete($thumbnail);
        }

        // update the database record with success flag
        $do->update(['upload_successful' => true]);
      } catch (\Exception $e) {
        Log::error($e);
      }
    }
}
