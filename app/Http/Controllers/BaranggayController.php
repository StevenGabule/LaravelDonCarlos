<?php

namespace App\Http\Controllers;

use App\Baranggay;
use App\Jobs\UploadImageArticle;
use App\Jobs\UploadImageBarangay;
use App\Traits\ImageHandle;
use App\Traits\UploadImage;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class BaranggayController extends Controller
{
  use ImageHandle;
  use UploadImage;

  public function index()
  {
    return view('backend.baranggay.index');
  }

  public function all(Request $request, $type)
  {
    $baranggay = null;
    if ($type === 'all') {
      $baranggay = Baranggay::latest();
    }

    if ($type === 'trash') {
      $baranggay = Baranggay::onlyTrashed()->get();
    }

    if ($type === 'drafted') {
      $baranggay = Baranggay::where('status', 0)->get();
    }

    if ($type === 'published') {
      $baranggay = Baranggay::where('status', 1)->get();
    }

    return DataTables::of($baranggay)->addColumn('action', static function ($data) {
      $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/baranggays/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removeBaranggay' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash-undo-alt mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item removeBaranggay' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
      $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreBaranggay' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash-restore-alt mr-2'></i> Restore
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
    })->addColumn('checkbox', '<input type="checkbox" name="baranggay_checkbox[]" class="baranggay_checkbox" value="{{$id}}" />')
      ->rawColumns(['action', 'checkbox'])
      ->make(true);
  }

  public function create()
  {
    return view('backend.baranggay.create');
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'population' => 'required',
      'address' => 'required',
    ]);

    $filename = '';

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();

      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

      $image->storeAs('uploads/barangays/original', $filename, 'tmp');
    }

    $barangay = Baranggay::create([
      'name' => $request->get('name'),
      'slug' => Str::slug($request->get('name')),
      'user_id' => Auth::id(),
      'population' => $request->get('population'),
      'status' => $request->get('status'),
      'avatar' => $filename,
      'short_description' => $request->get('short_description'),
      'description' => $request->get('description'),
      'address' => $request->get('address'),
      'disk' => config('site.upload_disk')
    ]);

    $id = $barangay->id;

    if ($filename != '') {
//      $this->upload($barangay, 'barangays');
      $this->dispatch(new UploadImageBarangay($id));
    }
    return response()->json(['success' => true, 'id' => $id]);
  }

  public function edit($id)
  {
    $baranggay = Baranggay::findOrFail($id);
    return view('backend.baranggay.edit', compact('baranggay'));
  }

  public function updateAjax(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'status' => 'required',
      'short_description' => 'required',
      'description' => 'required',
      'population' => 'required',
      'address' => 'required',
    ]);
    $filename = '';
    $baranggay_id = $request->input('baranggay_id');
    $baranggay = Baranggay::findOrFail($baranggay_id);

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $image->storeAs('uploads/barangays/original', $filename, 'tmp');
      $baranggay->avatar = $filename;
    }

    if ($filename != '') {
//      $this->upload($baranggay, 'barangays');
      $this->dispatch(new UploadImageBarangay($baranggay_id));
    }

    $baranggay->update([
      'name' => $request->get('name'),
      'slug' => Str::slug($request->get('name')),
      'user_id' => Auth::id(),
      'population' => $request->get('population'),
      'status' => $request->get('status'),
      'short_description' => $request->get('short_description'),
      'description' => $request->get('description'),
      'address' => $request->get('address'),
    ]);

    return response()->json(['success' => true]);
  }

  public function kill($ids)
  {
    $ids = explode(",", $ids);
    foreach ($ids as $id) {
      $baranggay = Baranggay::withTrashed()->where('id', $id)->firstOrFail();
      $splits = explode('/', $baranggay->avatar)[7];
      $publicId = explode('.', $splits)[0];
      Cloudder::delete($publicId, null);
      $baranggay->forceDelete();
    }
    return response()->json(['success' => true]);
  }

  public function massRemove(Request $request)
  {
    $baranggay_id = $request->input('id');
    if (is_array($baranggay_id)) {
      $baranggay = Baranggay::whereIn('id', $baranggay_id);
      if ($baranggay->delete()) {
        return response()->json(['success' => true]);
      }
    }
    Baranggay::where('id', $baranggay_id)->first()->delete();
    return response()->json(['success' => true]);
  }

  public function restore(Request $request)
  {
    $ids = $request->input('id');
    if (is_array($ids)) {
      Baranggay::withTrashed()->whereIn('id', $ids)->restore();
      return response()->json(['success' => true]);
    }
    Baranggay::withTrashed()->where('id', $ids)->first()->restore();
    return response()->json(['success' => true]);
  }

  public function clone(Request $request)
  {
    $ids = $request->input('id');
    $data = [];
    if (is_array($ids)) {
      $baranggays = Baranggay::whereIn('id', $ids)->get();
      foreach ($baranggays as $baranggay) {
        $temp = [
          'user_id' => Auth::id(),
          'name' => $baranggay->name,
          'slug' => $baranggay->slug,
          'short_description' => $baranggay->short_description,
          'description' => $baranggay->description,
          'status' => $baranggay->status,
          'population' => $baranggay->population,
          'address' => $baranggay->address,
          'deleted_at' => $baranggay->deleted_at,
          'created_at' => Carbon::now()
        ];
        $data[] = $temp;
      }
      Baranggay::insert($data);
      return response()->json(['success' => true], 200);
    }
  }
}
