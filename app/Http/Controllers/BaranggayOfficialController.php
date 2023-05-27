<?php

namespace App\Http\Controllers;

use App\Baranggay;
use App\BaranggayOfficial;
use App\Jobs\UploadImageBarangayOfficial;
use App\Traits\ImageHandle;
use App\Traits\UploadImage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class BaranggayOfficialController extends Controller
{
  use ImageHandle;
  use UploadImage;

  private $folderName;

  public function index()
  {
    $this->folderName = 'official_groups';
    $baranggays = Baranggay::latest()->get();
    return view('backend.officials.index', compact('baranggays'));
  }

  public function all(Request $request, $type)
  {
    $baranggayOfficials = null;
    if ($type === 'all') {
      $baranggayOfficials = BaranggayOfficial::with('baranggay')->latest();
    }

    if ($type === 'trash') {
      $baranggayOfficials = BaranggayOfficial::with('baranggay')->onlyTrashed()->get();
    }

    if ($type === 'drafted') {
      $baranggayOfficials = BaranggayOfficial::with('baranggay')->where('status', 0)->get();
    }

    if ($type === 'published') {
      $baranggayOfficials = BaranggayOfficial::with('baranggay')->where('status', 1)->get();
    }

    return DataTables::of($baranggayOfficials)->addColumn('action', static function ($data) {
      $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item editOfficial'
                            id='$data->id' href='javascript:void(0)'><i class='fad fa-file-edit mr-2'></i> Edit
                        </a><a class='dropdown-item removeBaranggay' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item killBaranggayOfficial' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
      $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreBaranggayOfficial' id='$data->id' href='javascript:void(0)'>
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
    })->addColumn('checkbox', '<input type="checkbox" name="bo_checkbox[]" class="bo_checkbox" id="{{$id}}" value="{{$id}}" />')
      ->editColumn('created_at', static function ($data) {
        return $data->created_at->format('d M Y');
      })
      ->rawColumns(['action', 'checkbox'])
      ->make(true);
  }

  public function store(Request $request): JsonResponse
  {
    $rules = [
      'name' => 'required',
      'baranggay_id' => 'required',
      'position' => 'required',
      'from' => 'required',
      'to' => 'required',
      'status' => 'required'
    ];

    $error = Validator::make($request->all(), $rules);

    if ($error->fails()) {
      return response()->json(['errors' => $error->errors()->all()]);
    }

    $filename = '';
    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $path = $request->file('avatar')->store('', '');

      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $filename = $path;
//      $image->storeAs('uploads/official_groups/original', $filename, 'tmp');
    }

    $official = BaranggayOfficial::create([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name,
      'position' => $request->position,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status,
      'avatar' => $filename,
      'disk' => config('site.upload_disk')
    ]);

    if ($filename != '') {
//      $this->upload($official, 'official_groups');
//      $this->dispatch(new UploadImageBarangayOfficial($official->id));
    }

    return response()->json(['success' => true]);
  }

  public function storeGroup(Request $request)
  {
    $rules = [
      'name_capitan' => 'required',
      'name_chairman' => 'required',
      'name_secretary' => 'required',
      'name_treasurer' => 'required',
      'baranggay_id' => 'required',
      'position_capitan' => 'required',
      'position_chairman' => 'required',
      'position_secretary' => 'required',
      'position_treasure' => 'required',
      'from' => 'required',
      'to' => 'required',
      'status' => 'required'
    ];
    $today =  Carbon::now();
    $error = Validator::make($request->all(), $rules);

    if ($error->fails()) {
      return response()->json(['errors' => $error->errors()->all()]);
    }

    $dataInsert = [];

    ////////  CAPTAIN //////////
    $filenameCaptainImage = '';
    if ($request->file('avatarCapitan')) {
      $image = $request->file('avatarCapitan');
      $pathCaptain = $request->file('avatarCapitan')->store('', '');
      $image->getPathName();
      $filenameCaptainImage = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
      $filenameCaptainImage = $pathCaptain;
//      $image->storeAs('uploads/official_groups/original', $filenameCaptainImage, 'tmp');
    }

    $addCaptain = BaranggayOfficial::create([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name_capitan,
      'position' => $request->position_capitan,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status,
      'avatar' => $filenameCaptainImage,
      'created_at' => $today,
      'disk' => config('site.upload_disk')
    ]);

    if ($filenameCaptainImage != '') {
//      $this->upload($addCaptain, 'official_groups');
//      $this->dispatch(new UploadImageBarangayOfficial($addCaptain->id));
    }

    ////////  CHAIRMAN //////////
    $filenameChairmanImage = '';
    if ($request->file('avatarChairman')) {
      $imageChairman = $request->file('avatarChairman');
      $pathAvatarChairman = $request->file('avatarChairman')->store('', '');
      $imageChairman->getPathName();
      $filenameChairmanImage = time() . '_' . preg_replace('/\s+/', '_', strtolower($imageChairman->getClientOriginalName()));
      $filenameChairmanImage = $pathAvatarChairman;
//      $imageChairman->storeAs('uploads/official_groups/original', $filenameChairmanImage, 'tmp');
    }

    $addChairman = BaranggayOfficial::create([
      'baranggay_id' => $request->input('baranggay_id'),
      'name' => $request->input('name_chairman'),
      'position' => $request->input('position_chairman'),
      'from' => $request->input('from'),
      'to' => $request->input('to'),
      'status' => $request->input('status'),
      'avatar' => $filenameChairmanImage,
      'created_at' => $today,
      'disk' => config('site.upload_disk')
    ]);

    if ($filenameChairmanImage != '') {
//      $this->upload($addChairman, 'official_groups');
//      $this->dispatch(new UploadImageBarangayOfficial($addChairman->id));
    }

    ////////  SECRETARY //////////
    $filenameSecretaryImage = null;

    if ($request->file('avatarSecretary')) {
      $imageSecretary = $request->file('avatarSecretary');
      $pathAvatarSecretary = $request->file('avatarSecretary')->store('', '');

      $imageSecretary->getPathName();
      $filenameSecretaryImage = time() . '_' . preg_replace('/\s+/', '_', strtolower($imageSecretary->getClientOriginalName()));
      $filenameSecretaryImage = $pathAvatarSecretary;
//      $imageSecretary->storeAs('uploads/official_groups/original', $filenameSecretaryImage, 'tmp');

    }

    $addSecretary = BaranggayOfficial::create([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name_secretary,
      'position' => $request->position_secretary,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status,
      'avatar' => $filenameSecretaryImage,
      'created_at' => $today,
      'disk' => config('site.upload_disk')
    ]);

    if ($filenameSecretaryImage != '') {
//      $this->upload($addSecretary, 'official_groups');
//      $this->dispatch(new UploadImageBarangayOfficial($addSecretary->id));
    }

    // treasure
    $filenameTreasurerImage = null;
    if ($request->file('avatarTreasurer')) {
      $imageTreasurer = $request->file('avatarTreasurer');
      $pathAvatarTreasurer = $request->file('avatarTreasurer')->store('', '');
      $imageTreasurer->getPathName();
      $filenameTreasurerImage = time() . '_' . preg_replace('/\s+/', '_', strtolower($imageTreasurer->getClientOriginalName()));
      $filenameTreasurerImage = $pathAvatarTreasurer;
//      $imageTreasurer->storeAs('uploads/official_groups/original', $filenameTreasurerImage, 'tmp');
    }

    $addTreasurer = BaranggayOfficial::create([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name_treasurer,
      'position' => $request->position_treasure,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status,
      'avatar' => $filenameTreasurerImage,
      'created_at' => $today,
      'disk' => config('site.upload_disk')
    ]);

    if ($filenameTreasurerImage != '') {
//      $this->upload($addTreasurer, 'official_groups');
//      $this->dispatch(new UploadImageBarangayOfficial($addTreasurer->id));
    }

    foreach ($request->position_kagawad as $key => $v) {
      $dataInsert[] = array(
        'baranggay_id' => $request->baranggay_id,
        'name' => $request->name_kagawad[$key],
        'position' => $request->position_kagawad[$key],
        'from' => $request->from,
        'to' => $request->to,
        'status' => $request->status,
        'avatar' => null,
        'created_at' => $today,
        'disk' => config('site.upload_disk')
      );
    }

    $officials = BaranggayOfficial::insert($dataInsert);
    return response()->json(['articles' => $request->all(), 'success' => $officials]);
  }

  public function edit($id)
  {
    $official = BaranggayOfficial::findOrFail($id);
    return response()->json(['official' => $official]);
  }

  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'required',
      'baranggay_id' => 'required',
      'position' => 'required',
      'from' => 'required',
      'to' => 'required',
      'status' => 'required'
    ];

    $error = Validator::make($request->all(), $rules);

    if ($error->fails()) {
      return response()->json(['errors' => $error->errors()->all()]);
    }

    $officials = BaranggayOfficial::findOFail($id);
    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $image->getPathName();

      $pathAvatar = $request->file('avatar')->store('', '');

      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
//      $image->storeAs('uploads/official_groups/original', $filename, 'tmp');
      $officials->avatar = $pathAvatar;

      if ($filename != '') {
//        $this->upload($officials, 'official_groups');
//        $this->dispatch(new UploadImageBarangayOfficial($officials->id));
      }
    }

    $officials->update([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name,
      'position' => $request->position,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status
    ]);

    return response()->json(['success' => true]);
  }

  public function ajaxUpdate(Request $request): JsonResponse
  {
    $rules = [
      'name' => 'required',
      'baranggay_id' => 'required',
      'position' => 'required',
      'from' => 'required',
      'to' => 'required',
      'status' => 'required'
    ];

    $error = Validator::make($request->all(), $rules);

    if ($error->fails()) {
      return response()->json(['errors' => $error->errors()->all()]);
    }

    $id = $request->input('official_id');
    $officials = BaranggayOfficial::findOrFail($id);

    if ($request->file('avatar')) {
      $image = $request->file('avatar');
      $pathOfficial = $request->file('avatar')->store('', '');

      $image->getPathName();
      $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
//      $image->storeAs('uploads/official_groups/original', $filename, 'tmp');
      $officials->avatar = $pathOfficial;
      if ($filename != '') {
//        $this->upload($officials, 'official_groups');
//        $this->dispatch(new UploadImageBarangayOfficial($officials->id));
      }
    }

    $officials->update([
      'baranggay_id' => $request->baranggay_id,
      'name' => $request->name,
      'position' => $request->position,
      'from' => $request->from,
      'to' => $request->to,
      'status' => $request->status
    ]);

    return response()->json(['success' => true]);
  }

  public function kill($ids)
  {
    $ids = explode(",", $ids);
    foreach ($ids as $id) {
      $officials = BaranggayOfficial::withTrashed()->where('id', $id)->firstOrFail();
      $officials->forceDelete();
    }
    return response()->json(['success' => true]);
  }

  public function massRemove(Request $request)
  {
    $baranggayOfficialIds = $request->input('id');
    if (is_array($baranggayOfficialIds)) {
      $officials = BaranggayOfficial::whereIn('id', $baranggayOfficialIds);
      if ($officials->delete()) {
        return response()->json(['success' => true]);
      }
    }
    BaranggayOfficial::where('id', $baranggayOfficialIds)->delete();
    return response()->json(['failed' => false]);
  }

  public function restore(Request $request)
  {
    $ids = $request->input('id');
    if (is_array($ids)) {
      BaranggayOfficial::withTrashed()->whereIn('id', $ids)->restore();
      return response()->json(['success' => true]);
    }
    BaranggayOfficial::withTrashed()->where('id', $ids)->first()->restore();
    return response()->json(['success' => true]);
  }

  public function clone(Request $request)
  {
    $ids = $request->input('id');
    $data = [];
    if (is_array($ids)) {
      $BaranggayOfficial = BaranggayOfficial::whereIn('id', $ids)->get();
      foreach ($BaranggayOfficial as $baranggay) {
        $temp = [
          'baranggay_id' => $baranggay->baranggay_id,
          'name' => $baranggay->name,
          'position' => $baranggay->position,
          'from' => $baranggay->from,
          'to' => $baranggay->to,
          'status' => $baranggay->status,
          'avatar' => $baranggay->avatar,
          'created_at' => Carbon::now()
        ];
        $data[] = $temp;
      }
      BaranggayOfficial::insert($data);
      return response()->json(['success' => true], 200);
    }
  }

  public function uploadImages($old, $image, $name, $model)
  {
    $thumbnailImage = Image::make($image);
    $thumbnailPath = public_path() . "/backend/uploads/$model/thumbnail/";
    $avatarPath = public_path() . "/backend/uploads/$model/small/";

    if ($old !== null) {
      $this->removeImages($old, $model);
    }

    $thumbnailImage->resize(244, 244)->save($thumbnailPath . $name);
    $thumbnailImage->resize(32, 32)->save($avatarPath . $name);
  }

  public function removeImages($image, $model)
  {
    $thumbnailPath = public_path() . "/backend/uploads/$model/thumbnail/$image";
    $avatarPath = public_path() . "/backend/uploads/$model/small/$image";
    if (File::exists($thumbnailPath)) File::delete($thumbnailPath);
    if (File::exists($avatarPath)) File::delete($avatarPath);
  }
}
