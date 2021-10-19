<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImagePageContent;
use App\PageContent;
use App\Traits\ImageHandle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
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
      return <<<EOT
       <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
          <a href="page-content/$data->id/edit" id="$data->id" class="btn btn-info btn-sm btnEdit">Edit</a>
       </div>
EOT;
    })->editColumn('created_at', static function ($data) {
      return $data->created_at->format('d, M Y');
    })->rawColumns(['action', 'created_at'])->make(true);
  }

  public function create()
  {
    return view('backend.page_content.create');
  }

  public function store(Request $request): JsonResponse
  {
    $request->validate([
      'title' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'avatar' => 'required|mimes:jpeg,gif,bmp,png',
    ]);

    $filename = '';

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $image->storeAs('uploads/page_content/original', $filename, 'tmp');
    }

    $pageContent = PageContent::create([
      'title' => $request->get('title'),
      'slug' => Str::slug($request->get('title')),
      'avatar' => $filename,
      'short_description' => $request->get('short_description'),
      'description' => $request->get('description'),
      'disk'=> config('site.upload_disk')
    ]);

    if ($filename != '') {
      $this->dispatch(new UploadImagePageContent($pageContent->id));
    }
    return response()->json(['id' => $pageContent->id]);
  }

  public function edit($id)
  {
    $page_content = PageContent::findOrFail($id);
    return view('backend.page_content.edit', compact('page_content'));
  }

  public function update_ajax(Request $request): JsonResponse
  {
    $request->validate([
      'title' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'avatar' => 'sometimes|mimes:jpeg,gif,bmp,png',
    ]);

    $pageContent = PageContent::findOrFail($request->input('page_content_id'));

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $image->storeAs('uploads/page_content/original', $filename, 'tmp');
      $this->dispatch(new UploadImagePageContent($pageContent->id));
      $pageContent->avatar = $filename;
    }

    $pageContent->update([
      'title' => $request->get('title'),
      'slug' => Str::slug($request->get('title')),
      'description' => $request->get('description'),
      'short_description' => $request->get('short_description'),
    ]);

    // dispatch a job to handle the image manipulation
    return response()->json(['updated' => true]);
  }
}
