<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageServiceArticle;
use App\Services;
use App\ServicesArticle;
use App\Traits\ImageHandle;
use App\Traits\UploadImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class ServicesArticleController extends Controller
{
  use ImageHandle;
  use UploadImage;

  public function index()
  {
    return view('backend.services-articles.index');
  }

  public function all(Request $request, $type)
  {
    $serviceArticles = null;

    if ($type === 'all') {
      $serviceArticles = ServicesArticle::with('category')->orderByDesc('created_at')
        ->get();
    }

    if ($type === 'trash') {
      $serviceArticles = ServicesArticle::with('category')
        ->onlyTrashed()
        ->orderByDesc('created_at')
        ->get();
    }

    if ($type === 'drafted') {
      $serviceArticles = ServicesArticle::with('category')
        ->where('status', '=', 0)
        ->orderByDesc('created_at')
        ->get();
    }

    if ($type === 'published') {
      $serviceArticles = ServicesArticle::with('category')
        ->where('status', '=', 1)
        ->orderByDesc('created_at')
        ->get();
    }

    return DataTables::of($serviceArticles)->addColumn('action', static function ($data) {
      $btn = ($data->deleted_at === null) ? "
                        <a class=\"dropdown-item\" href=\"$data->id\"><i class=\"fad fa-eye mr-2\"></i> View</a>
                        <a class=\"dropdown-item\" id=\"$data->id\" href=\"/admin/service-article/$data->id/edit\"><i class=\"fad fa-file-edit mr-2\"></i> Edit</a><a class=\"dropdown-item removeServiceArticle\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Move Trash
                        </a>" : "<a class=\"dropdown-item killServiceSA\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Delete
                        </a>";
      $btnRestore = ($data->deleted_at !== null) ? "<a class=\"dropdown-item restoreServiceSA\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Restore
                        </a>" : null;
      $button = <<<EOT
                <div class="dropdown no-arrow" style="width:50px">
                  <a href="javascript:void(0)" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fad fa-ellipsis-h"></i>
                  </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" style="font-size: 13px;">
                        <h6 class="dropdown-header">Actions</h6>
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
      return $button;
    })->addColumn('checkbox', '<input type="checkbox" name="serviceArticle_checkbox[]" class="serviceArticle_checkbox" value="{{$id}}" />')
      ->rawColumns(['action', 'checkbox'])
      ->make(true);
  }

  public function create()
  {
    $categories = Services::all();
    return view('backend.services-articles.create', compact('categories'));
  }

  /**
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): JsonResponse
  {
    $this->validate($request, [
      'name' => 'required',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'service_id' => 'required',
    ]);

    $filename = '';

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $path = $request->file('avatar')->store('', '');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $filename = $path;
//      $image->storeAs('uploads/services_article/original', $filename, 'tmp');
    }

    $services_article = ServicesArticle::create([
      'user_id' => Auth::id(),
      'services_id' => $request->get('service_id'),
      'name' => $request->get('name'),
      'slug' => Str::slug($request->get('name')),
      'status' => $request->get('status'),
      'avatar' => $filename,
      'short_description' => $request->get('short_description'),
      'description' => $request->get('description'),
      'disk' => config('site.upload_disk')
    ]);

    if ($filename != '') {
//      $this->upload($services_article, 'services_article');
      $this->dispatch(new UploadImageServiceArticle($services_article->id));
    }

    return response()->json(['success' => true, 'id' => $services_article->id]);
  }

  public function edit($id)
  {
    $sa = ServicesArticle::findOrFail($id);
    $categories = Services::all();
    return view('backend.services-articles.edit', compact('sa', 'categories'));
  }

  public function updateAjax(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'service_id' => 'required',
    ]);

    $serviceArticle = ServicesArticle::findOrFail($request->input('service_article_id'));

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $path = $request->file('avatar')->store('', '');

      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
//      $image->storeAs('uploads/services_article/original', $filename, 'tmp');
      $serviceArticle->avatar = $path;
//      $this->upload($serviceArticle, 'services_article');
//      $this->dispatch(new UploadImageServiceArticle($serviceArticle->id));
    }

    $serviceArticle->name = $request->get('name');
    $serviceArticle->short_description = $request->get('short_description');
    $serviceArticle->description = $request->get('description');
    $serviceArticle->services_id = $request->get('service_id');
    $serviceArticle->slug = Str::slug($request->get('name'));
    $serviceArticle->status = $request->get('status');
    $serviceArticle->save();
    return response()->json(['success' => true]);
  }

  public function update(Request $request)
  {
    return response()->json([]);
  }

  public function restore(Request $request)
  {
    $ids = $request->input('id');
    if (is_array($ids)) {
      ServicesArticle::withTrashed()->whereIn('id', $ids)->restore();
      return response()->json(['success' => true]);
    }
    ServicesArticle::withTrashed()->where('id', $ids)->first()->restore();
    return response()->json(['success' => true]);
  }

  public function kill($ids)
  {
    $ids = explode(",", $ids);
    foreach ($ids as $id) {
      $service_article = ServicesArticle::withTrashed()->where('id', $id)->first();
      $service_article->forceDelete();
    }
    return response()->json(['success' => true]);
  }

  public function massRemove(Request $request)
  {
    $serviceArticleID = $request->input('id');
    if (is_array($serviceArticleID)) {
      $serviceArticles = ServicesArticle::whereIn('id', $serviceArticleID);
      if ($serviceArticles->delete()) {
        return response()->json(['success' => true, 'msg' => 'Service article has been moved to trash']);
      }
    }
    ServicesArticle::where('id', $serviceArticleID)->first()->delete();
    return response()->json(['success' => true, 'msg' => 'Service article has been moved to trash']);

  }
}
