<?php

namespace App\Http\Controllers;

use App\Baranggay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BaranggayController extends Controller
{

    public function index()
    {
        return view('backend.baranggay.index');
    }

    public function all(Request $request, $type)
    {
        $baranggay = null;
        if ($type === 'all') {
            $baranggay = Baranggay::latest()->get();
        }

        if ($type === 'trash') {
            $baranggay = Baranggay::onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $baranggay = Baranggay::where('status', '=', 0)->get();
        }

        if ($type === 'published') {
            $baranggay = Baranggay::where('status', '=', 1)->get();
        }

        return DataTables::of($baranggay)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "<a class=\"dropdown-item removeBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Move Trash  
                        </a>" : "<a class=\"dropdown-item removeBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Delete 
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class=\"dropdown-item restoreBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Restore 
                        </a>" : null;
            $button = <<<EOT
                <div class="dropdown no-arrow" style="width:50px">
                  <a href="javascript:void(0)" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fad fa-ellipsis-h"></i> 
                  </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" style="font-size: 13px;">
                        <h6 class="dropdown-header">Actions</h6>
                        <a class="dropdown-item" href="$data->id"><i class="fad fa-eye mr-2"></i> View</a>
                        <a class="dropdown-item" id="$data->id" href="/admin/article/$data->id/edit"><i class="fad fa-file-edit mr-2"></i> Edit</a>
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="baranggay_checkbox[]" class="baranggay_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='/backend/uploads/baranggays/$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.baranggay.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:6|max:100',
            'status' => 'required',
            'short_description' => 'required|min:6|max:100',
            'description' => 'required|min:10',
            'population' => 'required',
            'address' => 'required|min:10',
        ]);

        $new_name = null;

        if ($image = $request->file('avatar')) {
            $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/uploads/baranggays'), $new_name);
        }

        $sa = Baranggay::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'user_id' => Auth::id(),
            'population' => $request->get('population'),
            'status' => $request->get('status'),
            'avatar' => $new_name,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['success' => true, 'id' => $sa->id]);
    }

    public function edit($id)
    {
        $baranggay = Baranggay::findOrFail($id);
        return view('backend.baranggay.edit', compact('baranggay'));
    }

    public function updateAjax(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:6|max:100',
            'status' => 'required',
            'short_description' => 'required|min:6|max:100',
            'description' => 'required|min:10',
            'population' => 'required',
            'address' => 'required|min:10',
        ]);


        $error_array = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            $baranggay = Baranggay::findOrFail($request->input('baranggay_id'));

            if ($image = $request->file('avatar')) {
                $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads/baranggays'), $new_name);
                $baranggay->avatar = $new_name;
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
        }
        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $baranggay->id
        ];
        return response()->json($output);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Baranggay::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        Baranggay::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function massRemove(Request $request)
    {
        $baranggay_id = $request->input('id');
        $baranggay = Baranggay::whereIn('id', $baranggay_id);
        if ($baranggay->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['failed' => false]);
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
