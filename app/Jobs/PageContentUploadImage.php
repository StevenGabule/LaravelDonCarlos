<?php

namespace App\Jobs;

use App\PageContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PageContentUploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pageContent;

    public function __construct(PageContent $pageContent)
    {
        $this->pageContent = $pageContent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = $this->pageContent->disk;
        $filename = $this->pageContent->avatar;
        $original_file = storage_path() . '/uploads/original/' . $filename;

        try {
            // create the large image and save to tmp disk
            Image::make($original_file)->fit(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($large = storage_path('uploads/large/' . $filename));

            // create the thumbnail image
            Image::make($original_file)->fit(250, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnail = storage_path("uploads/thumbnail/$filename"));

            // create the small image
            Image::make($original_file)->fit(40, 40, function ($constraint) {
                $constraint->aspectRatio();
            })->save($small = storage_path("uploads/small/$filename"));

            // store images to permanent disk
            // original image
            if (Storage::disk($disk)->put("uploads/page-content/original/$filename", fopen($original_file, 'r+'))) {
                File::delete($original_file);
            }

            // large image
            if (Storage::disk($disk)->put("uploads/page-content/large/$filename", fopen($large, 'r+'))) {
                File::delete($large);
            }

            // thumbnail image
            if (Storage::disk($disk)->put("uploads/page-content/thumbnail/$filename", fopen($thumbnail, 'r+'))) {
                File::delete($thumbnail);
            }

            // small image
            if (Storage::disk($disk)->put("uploads/page-content/small/$filename", fopen($small, 'r+'))) {
                File::delete($small);
            }

            // update the database record with success flag
            $this->pageContent->update([
                'upload_successful' => true
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
