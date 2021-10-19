<?php

namespace App\Jobs;

use App\BaranggayOfficial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue,SerializesModels};
use Illuminate\Support\Facades\{File, Log, Storage};
use Intervention\Image\Facades\Image;

class UploadImageBarangayOfficial implements ShouldQueue
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
      $barangayOfficial = BaranggayOfficial::where('id', $this->id)->first();
      $disk = $barangayOfficial->disk;
      $filename = $barangayOfficial->avatar;
      $original_file = storage_path() . '/uploads/official_groups/original/' . $filename;

      try {
        // create the large image and save to tmp disk
        Image::make($original_file)->fit(800, 600, function ($constraint) {
          $constraint->aspectRatio();
        })->save($large = storage_path('uploads/official_groups/large/' . $filename));

        // create the thumbnail image
        Image::make($original_file)->fit(250, 200, function ($constraint) {
          $constraint->aspectRatio();
        })->save($thumbnail = storage_path('uploads/official_groups/thumbnail/' . $filename));

        // store images to permanent disk
        // original image
        if (Storage::disk($disk)->put("uploads/official_groups/original/$filename", fopen($original_file, 'r+'))) {
          File::delete($original_file);
        }

        // large image
        if (Storage::disk($disk)->put("uploads/official_groups/large/$filename", fopen($large, 'r+'))) {
          File::delete($large);
        }

        // thumbnail image
        if (Storage::disk($disk)->put("uploads/official_groups/thumbnail/$filename", fopen($thumbnail, 'r+'))) {
          File::delete($thumbnail);
        }

        // update the database record with success flag
        $barangayOfficial->update(['upload_successful' => true]);
      } catch (\Exception $e) {
        Log::error($e);
      }
    }
}
