<?php

namespace App\Http\Controllers;

use App\ContentNeed;
use App\Jobs\UploadImageContentType;
use App\Traits\ImageHandle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class ContentNeedController extends Controller
{
  use ImageHandle;

  public function index()
  {
    return view('backend.Award-Mandate.index');
  }

  public function all($type)
  {
    $articles = null;

    if ($type === 'all') {
      $contentNeeds = ContentNeed::latest()->get();
    }

    if ($type === 'trash') {
      $contentNeeds = ContentNeed::onlyTrashed()->get();
    }

    if ($type === 'drafted') {
      $contentNeeds = ContentNeed::where('status', 0)->get();
    }

    if ($type === 'published') {
      $contentNeeds = ContentNeed::where('status', 1)->get();
    }

    return DataTables::of($contentNeeds)->addColumn('action', static function ($data) {
      $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/need-content/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removeArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item' id='$data->id' href='javascript:void(0)'>
                          No action
                        </a>";
      $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash-restore mr-2'></i> Restore
                        </a>" : null;
      return <<<EOT
                <div class="dropdown no-arrow" style="width:50px">
                  <a href="javascript:void(0)" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fad fa-ellipsis-h"></i>
                  </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" style="font-size: 13px;">
                        <h6 class="dropdown-header">Actions</h6>
                        $btn
                    </div>
                </div>
EOT;
    })->addColumn('checkbox', '<input type="checkbox" name="content_need[]" class="content_need" value="{{$id}}" />')
      ->editColumn('need_type', function ($data) {
        return $data->need_type == 1 ? 'Award' : 'Mandate';
      })->editColumn('created_at', function ($data) {
        return $data->created_at->format('d, M Y') . ' ' . $data->created_at->diffForHumans();
      })->rawColumns(['action', 'checkbox', 'need_type', 'created_at'])->make(true);
  }

  public function create()
  {
    return view('backend.Award-Mandate.create');
  }

  /**
   * @throws ValidationException
   */
  public function store(Request $request): JsonResponse
  {
    $this->validate($request, [
      'title' => 'required|unique:articles',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'need_type' => 'required',
    ]);

    $filename = '';

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $image->storeAs('uploads/content_needs/original', $filename, 'tmp');
    }

    $content = ContentNeed::create([
      'title' => $request->title,
      'slug' => Str::slug($request->title),
      'short_description' => $request->short_description,
      'description' => $request->description,
      'status' => $request->status,
      'avatar' => $filename,
      'user_id' => Auth::id(),
      'need_type' => $request->need_type,
      'disk' => config('site.upload_disk')
    ]);

    if ($filename != '') {
      $this->dispatch(new UploadImageContentType($content->id));
    }

    return response()->json(['id' => $content->id], 200);
  }

  public function edit($id)
  {
    $content = ContentNeed::findOrFail($id);
    return view('backend.Award-Mandate.edit', compact('content'));
  }

  /**
   * @throws ValidationException
   */
  public function update_ajax(Request $request): JsonResponse
  {
    $this->validate($request, [
      'title' => 'required|unique:articles',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'need_type' => 'required',
    ]);

    $content = ContentNeed::findOrFail($request->input('content_need_id'));

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $image->storeAs('uploads/content_needs/original', $filename, 'tmp');
      $content->avatar = $filename;
      $this->dispatch(new UploadImageContentType($content->id));
    }

    $content->update([
      'title' => $request->title,
      'slug' => Str::slug($request->title),
      'short_description' => $request->short_description,
      'description' => $request->description,
      'status' => $request->status,
      'need_type' => $request->need_type
    ]);

    return response()->json(['updated' => true]);
  }

  public function clone(Request $request): JsonResponse
  {
    $ids = $request->input('id');
    $data = [];
    if (is_array($ids)) {
      $contents = ContentNeed::whereIn('id', $ids)->get();
      foreach ($contents as $content) {
        $temp = [
          'user_id' => Auth::id(),
          'title' => $content->title,
          'slug' => Str::slug($content->title),
          'short_description' => $content->short_description,
          'description' => $content->description,
          'status' => false,
          'need_type' => $content->need_type,
          'avatar' => $content->avatar,
          'user_d' => Auth::id(),
          'created_at' => Carbon::now()
        ];
        $data[] = $temp;
      }
      ContentNeed::insert($data);
      return response()->json(['content-need' => $contents, 'ids' => $ids, 'data' => $data]);
    }
  }

  public function remove(Request $request): JsonResponse
  {
    $contentIdArray = $request->input('id');
    if (is_array($contentIdArray)) {
      $articles = ContentNeed::whereIn('id', $contentIdArray);
      if ($articles->delete()) {
        return response()->json(['success' => true]);
      }
    }
    ContentNeed::where('id', $contentIdArray)->delete();
    return response()->json(['failed' => false]);
  }

  public function restore(Request $request): JsonResponse
  {
    $ids = $request->input('id');
    if (is_array($ids)) {
      ContentNeed::withTrashed()->whereIn('id', $ids)->restore();
      return response()->json(['success' => true]);
    }
    ContentNeed::withTrashed()->where('id', $ids)->first()->restore();
    return response()->json(['success' => true]);
  }

  public function kill($ids)
  {
    $ids = explode(",", $ids);
    foreach ($ids as $id) {
      $needs = ContentNeed::withTrashed()->where('id', $id)->first();
      $needs->forceDelete();
    }
    return response()->json(['success' => true]);
  }
}
