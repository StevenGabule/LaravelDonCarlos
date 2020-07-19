<?php

namespace App\Http\Controllers;

use App\Activities;
use App\DepartmentCategories;
use App\DepartmentOffices;
use App\Traits\ImageHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class DepartmentOfficesController extends Controller
{
    use ImageHandle;

    public function index()
    {
        return view('backend.department_offices.index');
    }

    public function all($type)
    {
        if ($type === 'all') {
            $offices = DepartmentOffices::with('department_categories')->latest();
        }

        if ($type === 'drafted') {
            $offices = DepartmentOffices::with('department_categories')->where('status', 0)->get();
        }

        if ($type === 'published') {
            $offices = DepartmentOffices::with('department_categories')->where('status', 1)->get();
        }

        if ($type === 'trash') {
            $offices = DepartmentOffices::with('department_categories')->onlyTrashed()->get();
        }

        return DataTables::of($offices)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/department-offices/$data->id/edit'>
                            <i class='fad fa-file-edit mr-2'></i> Edit
                        </a>
                        <a class='dropdown-item removeOffice' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>"
                :
                "<a class='dropdown-item kill' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreOffice' id='$data->id' href='javascript:void(0)'>
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
        })->addColumn('checkbox', '<input type="checkbox" name="office_checkbox[]" class="office_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->editColumn('created_at', static function ($data) {
                return $data->created_at->format('d, M Y');
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function create()
    {
        $departments = DepartmentCategories::latest()->get();
        return view('backend.department_offices.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|min:6',
            'short_description' => 'required|max:255',
            'description' => 'required|min:10',
            'department_category_id' => 'required',
            'status' => 'required',
        ]);

        $office = null;
        $image_url = null;

        if ($request->file('avatar')) {
            /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'office');*/
            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        $office = DepartmentOffices::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'user_id' => Auth::id(),
            'status' => $request->get('status'),
            'department_category_id' => $request->get('department_category_id'),
            'avatar' => $image_url,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['id' => $office->id]);
    }


    public function edit($id)
    {
        $departments = DepartmentCategories::latest()->get();
        $office = DepartmentOffices::findOrFail($id);
        return view('backend.department_offices.edit', compact('office', 'departments'));
    }

    public function updateOffice(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|min:6',
            'short_description' => 'required|max:255',
            'description' => 'required|min:10',
            'department_category_id' => 'required',
            'status' => 'required',
        ]);

        $id = $request->input('office_id');
        $office = DepartmentOffices::where('id', $id)->first();

        if ($originalImage = $request->file('avatar')) {
            /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($office->avatar, $originalImage, $name, 'office');
            $office->avatar = $name;*/
            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $office->avatar = $image_url;
        }

        $office->update([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'user_id' => Auth::id(),
            'status' => $request->get('status'),
            'department_category_id' => $request->get('department_category_id'),
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['success' => true]);
    }

    public function massRemove(Request $request)
    {
        $officesId = $request->input('id');
        if (is_array($officesId)) {
            $offices = DepartmentOffices::whereIn('id', $officesId);
            if ($offices->delete()) {
                return response()->json(['success' => true]);
            }
        }

        DepartmentOffices::findOrFail($officesId)->delete();
        return response()->json(['success' => true]);
    }
}
