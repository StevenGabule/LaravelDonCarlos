<?php

namespace App\Http\Controllers;

use App\Baranggay;
use App\BaranggayOfficial;
use App\Traits\ImageHandle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class BaranggayOfficialController extends Controller
{
    use ImageHandle;

    public function index()
    {
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
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='$data->avatar' alt='No Image found' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->editColumn('created_at', static function($data) {
                return $data->created_at->format('d M Y');
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function store(Request $request)
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

        $image_url = null;

        if ($originalImage = $request->file('avatar')) {
            /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'officials');*/
            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }


        BaranggayOfficial::create([
            'baranggay_id' => $request->baranggay_id,
            'name' => $request->name,
            'position' => $request->position,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
            'avatar' => $image_url
        ]);

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

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $dataInsert = [];

        $captainImage = null;

        if ($request->file('avatarCapitan')) {
           /* $captainImage = mt_rand() . '.' . $originalImage1->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage1, $captainImage, 'officials');*/

            $image = $request->file('avatarCapitan')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $captainImage = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        // captain
        $dataInsert[] = array(
            'baranggay_id' => $request->baranggay_id,
            'name' => $request->name_capitan,
            'position' => $request->position_capitan,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
            'avatar' => $captainImage,
            'created_at' => Carbon::now(),
        );

        $avatarChairman = null;

        if ($request->file('avatarChairman')) {
            /*$avatarChairman = mt_rand() . '.' . $originalImage2->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage2, $avatarChairman, 'officials');*/

            $image = $request->file('avatarChairman')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $avatarChairman = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        // Chairman
        $dataInsert[] = array(
            'baranggay_id' => $request->input('baranggay_id'),
            'name' => $request->input('name_chairman'),
            'position' => $request->input('position_chairman'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'status' => $request->input('status'),
            'avatar' => $avatarChairman,
            'created_at' => Carbon::now(),
        );

        $avatarSecretary = null;

        if ($originalImage3 = $request->file('avatarSecretary')) {
            /*$avatarSecretary = mt_rand() . '.' . $originalImage3->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage3, $avatarSecretary, 'officials');*/
            $image = $request->file('avatarSecretary')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $avatarSecretary = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        // Secretary
        $dataInsert[] = array(
            'baranggay_id' => $request->baranggay_id,
            'name' => $request->name_secretary,
            'position' => $request->position_secretary,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
            'avatar' => $avatarSecretary,
            'created_at' => Carbon::now(),
        );

        // treasure
        $avatarTreasure = null;

        if ($request->file('avatarTreasurer')) {
            /*$avatarTreasure = mt_rand() . '.' . $originalImage4->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage4, $avatarTreasure, 'officials');*/
            $image = $request->file('avatarTreasurer')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $avatarTreasure = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        $dataInsert[] = array(
            'baranggay_id' => $request->baranggay_id,
            'name' => $request->name_treasurer,
            'position' => $request->position_treasure,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
            'avatar' => $avatarTreasure,
            'created_at' => Carbon::now(),
        );

        foreach ($request->position_kagawad as $key => $v) {
            $data = array(
                'baranggay_id' => $request->baranggay_id,
                'name' => $request->name_kagawad[$key],
                'position' => $request->position_kagawad[$key],
                'from' => $request->from,
                'to' => $request->to,
                'status' => $request->status,
                'avatar' => null,
                'created_at' => Carbon::now(),
            );
            $dataInsert[] = $data;
        }

        BaranggayOfficial::insert($dataInsert);

        return response()->json(['articles' => $request->all(), 'success' => true]);
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
            /*$new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/uploads/officials'), $new_name);
            $officials->avatar = $new_name;*/

            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $officials->avatar = $image_url;
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

    public function ajaxUpdate(Request $request)
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
            /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($officials->avatar, $originalImage, $name, 'officials');
            $officials->avatar = $name;*/

            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $officials->avatar = $image_url;
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

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $official = BaranggayOfficial::withTrashed()->where('id', $id)->first();
                $this->removeImages($official->avatar, 'officials');
                $official->forceDelete();
            }
            return response()->json(['success' => true]);
        }
        $official = BaranggayOfficial::withTrashed()->where('id', $ids)->first();
        $this->removeImages($official->avatar, 'officials');
        $official->forceDelete();
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
