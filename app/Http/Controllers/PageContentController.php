<?php

namespace App\Http\Controllers;

use App\Article;
use App\DepartmentCategories;
use App\Jobs\PageContentUploadImage;
use App\PageContent;
use App\Traits\ImageHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;

class PageContentController extends Controller
{
    use ImageHandle;

    public function index()
    {
        return view('backend.page_content.index');
    }

    public function all()
    {
        $pageContent = PageContent::latest()->get();
        return DataTables::of($pageContent)->addColumn('action', static function ($data) {
            $button = <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <a href="page-content/$data->id/edit" id="$data->id" class="btn btn-info btn-sm btnEdit">Edit</a>
               </div>
EOT;
            return $button;
        })->editColumn('created_at', static function ($data) {
            return $data->created_at->format('d, M Y');
        })->editColumn('avatar', static function ($data) {
            return $data->avatar === null ? "<i class='fad fa-images'></i>" : "<img src=\"/storage/uploads/page-content/small/{$data->avatar}\" class='rounded-circle' />";
        })->rawColumns(['action', 'created_at', 'avatar'])->make(true);
    }

    public function create()
    {
        return view('backend.page_content.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'avatar' => 'required|mimes:jpeg,gif,bmp,png',
        ]);

        $originalImage = $request->file('avatar');
        // get the image
        $image_path = $originalImage->getPathName();

        // get the original file name and replace any with _
        // business Card.png = timestamp()_business_card.png
        $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($originalImage->getClientOriginalName()));

        // move the image to the temporary location (tmp)
        $tmp = $originalImage->storeAs('uploads/original', $filename, 'tmp');

        /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
        $this->uploadImages(null, $originalImage, $name, 'page-content');*/

        $pageContent = PageContent::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'avatar' => $filename,
            'disk' => 'public',
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
        ]);

        // dispatch a job to handle the image manipulation
        // $this->dispatch(new PageContentUploadImage($pageContent));
        $uploads = storage_path() . '/uploads';
        $original = storage_path() . '/uploads/original';
        $large = storage_path() . '/uploads/large';
        $thumbnail = storage_path() . '/uploads/thumbnail';
        $small = storage_path() . '/uploads/small';

        Storage::makeDirectory($uploads);
        Storage::makeDirectory($original);
        Storage::makeDirectory($large);
        Storage::makeDirectory($thumbnail);
        Storage::makeDirectory($small);
        
        $disk = $pageContent->disk;
        $filename = $pageContent->avatar;
        $original_file =  $original . '/' . $filename;

        /*File::exists($uploads) or File::makeDirectory($uploads, 0777, true,true);
        File::exists($original) or File::makeDirectory($original, 0777, true,true);
        File::exists($large) or File::makeDirectory($large, 0777, true,true);
        File::exists($thumbnail) or File::makeDirectory($thumbnail, 0777, true,true);
        File::exists($small) or File::makeDirectory($small, 0777, true,true);*/

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
        /*if (Storage::disk($disk)->put("uploads/page-content/original/$filename", fopen($original_file, 'r+'))) {
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
        }*/

        // update the database record with success flag
        $pageContent->update([
            'upload_successful' => true
        ]);

        $output = ['id' => $pageContent->id];
        return response()->json($output);
    }

    public function edit($id)
    {
        $page_content = PageContent::findOrFail($id);
        return view('backend.page_content.edit', compact('page_content'));
    }

    public function update_ajax(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'avatar' => 'required|mimes:jpeg,gif,bmp,png',
        ]);

        $pageContent = PageContent::findOrFail($request->input('page_content_id'));

        foreach (['small', 'thumbnail', 'large', 'original'] as $size) {
            if (Storage::disk($pageContent->disk)->exists("uploads/page-content/{$size}/" . $pageContent->avatar)) {
                Storage::disk($pageContent->disk)->delete("uploads/page-content/{$size}/" . $pageContent->avatar);
            }
        }

        /*if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($pageContent->avatar, $originalImage, $name, 'page-content');
            $pageContent->avatar = $name;
        }*/

        $originalImage = $request->file('avatar');

        // get the image
        $originalImage->getPathName();

        // get the original file name and replace any with _
        // business Card.png = timestamp()_business_card.png
        $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($originalImage->getClientOriginalName()));

        // move the image to the temporary location (tmp)
        $originalImage->storeAs('uploads/original', $filename, 'tmp');

        $pageContent->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'avatar' => $filename,
            'short_description' => $request->get('short_description'),
        ]);

        // dispatch a job to handle the image manipulation
        $this->dispatch(new PageContentUploadImage($pageContent));
        return response()->json(['updated' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PageContent $pageContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageContent $pageContent)
    {
        //
    }
}
