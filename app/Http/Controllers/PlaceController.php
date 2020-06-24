<?php

namespace App\Http\Controllers;

use App\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PlaceController extends Controller
{
    public function index()
    {
        return view('backend.tourism.index');
    }

    public function all(Request $request, $type)
    {
        if ($type === 'all') {
            $places = Place::latest()->get();
        }

        if ($type === 'drafted') {
            $places = Place::where('status', 0)->get();
        }

        if ($type === 'published') {
            $places = Place::where('status', 1)->get();
        }

        if ($type === 'trash') {
            $places = Place::onlyTrashed()->get();
        }

        return DataTables::of($places)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/place/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removePlace' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash  
                        </a>" : "<a class='dropdown-item killArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete 
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restorePlace' id='$data->id' href='javascript:void(0)'>
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
        })->addColumn('checkbox', '<input type="checkbox" name="place_checkbox[]" class="place_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.tourism.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $new_name = null;

        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/uploads/places'), $new_name);
        }

        $place = Place::create([
            'user_id' => Auth::id(),
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('slug')),
            'status' => $request->get('status'),
            'address' => $request->get('address'),
            'avatar' => $new_name,
            'categories' => 'uncategories',
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
        ]);

        return response()->json(['success' => true, 'id' => $place->id]);
    }

    public function edit(place $place)
    {
        return view('backend.tourism.edit', compact('place'));
    }

    public function updateAjax(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'status' => 'required',
            'description' => 'required',
            'short_description' => 'required',
        ]);

        $place = Place::findOrFail($request->input('place_id'));

        $error_array = array();

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->file('avatar')) {
                $image = $request->file('avatar');
                $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads/places'), $new_name);
                $place->avatar = $new_name;
            }

            $place->name = $request->get('name');
            $place->slug = Str::slug($request->get('name'));
            $place->short_description = $request->get('short_description');
            $place->description = $request->get('description');
            $place->address = $request->get('address');
            $place->status = $request->get('status');
            $place->save();
        }

        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $place->id
        ];

        return response()->json($output);
    }


    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        if ($place) {
            $place->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['failed' => true]);
    }

    public function massRemove(Request $request)
    {
        $placeIdArray = $request->input('id');
        $places = Place::whereIn('id', $placeIdArray);
        if ($places->delete()) {
            return response()->json(['success' => true, 'msg' => 'Article has been moved to trash']);
        }
        return response()->json(['failed' => false, 'msg' => 'Error has been composed']);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Place::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        Place::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Place::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        Place::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function clone(Request $request)
    {
        $ids = $request->input('id');
        $data = [];
        if (is_array($ids)) {
            $places = Place::whereIn('id', $ids)->get();
            foreach ($places as $palce) {
                $temp = [
                    'user_id' => Auth::id(),
                    'name' => $palce->name,
                    'short_description' => $palce->short_description,
                    'description' => $palce->description,
                    'slug' => $palce->slug,
                    'status' => $palce->status,
                    'address' => $palce->address,
                    'avatar' => null,
                    'categories' => 'uncategories',
                    'created_at' => Carbon::now()
                ];
                $data[] = $temp;
            }
            Place::insert($data);
            return response()->json(['places' => $places, 'ids' => $ids, 'data' => $data]);
        }
    }

}
