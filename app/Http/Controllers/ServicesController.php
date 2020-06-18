<?php

namespace App\Http\Controllers;

use App\Services;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServicesController extends Controller
{
    public function index()
    {
        return view('backend.services.index');
    }

    public function all(Request $request, $type)
    {
        $services = null;

        if ($type === 'all') {
            $services = Services::latest()->get();
        }

        if ($type === 'drafted') {
            $services = Services::where('status', 0)->get();
        }

        if ($type === 'published') {
            $services = Services::where('status', 1)->get();
        }

        if ($type === 'trash') {
            $services = Services::onlyTrashed()->get();
        }

        return DataTables::of($services)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "<a class=\"dropdown-item removePlace\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Move Trash  
                        </a>" : "<a class=\"dropdown-item killService\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Delete 
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class=\"dropdown-item restoreService\" id=\"$data->id\" href=\"javascript:void(0)\">
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
                        <a class="dropdown-item editServices" id="$data->id" href="javascript:void(0)"><i class="fad fa-file-edit mr-2"></i> Edit</a>
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="service_checkbox[]" class="service_checkbox" value="{{$id}}" />')
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'status' => 'required'
        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Services::create([
            'name' => $request->name,
            'status' => $request->status,
            'short_description' => $request->input('description', null)
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\services $services
     * @return \Illuminate\Http\Response
     */
    public function show(services $services)
    {
        //
    }

    public function edit($id)
    {
        $service = Services::findOrFail($id);
        return response()->json(['service' => $service]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'status' => 'required'
        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $service = Services::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'status' => $request->status,
            'short_description' => $request->input('description', null)
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        if ($service) {
            $service->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['failed' => true]);
    }

    public function massRemove(Request $request)
    {
        $serviceIdArray = $request->input('id');
        $services = Services::whereIn('id', $serviceIdArray);
        if ($services->delete()) {
            return response()->json(['success' => true, 'msg' => 'Services has been moved to trash']);
        }
        return response()->json(['failed' => false, 'msg' => 'Error has been composed']);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Services::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        Services::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Services::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        Services::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }
}
