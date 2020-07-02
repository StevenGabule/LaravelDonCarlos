<?php

namespace App\Http\Controllers;

use App\DepartmentCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DepartmentCategoriesController extends Controller
{

    public function index()
    {
        return view('backend.departments.index');
    }

    public function all()
    {
        $departments = DepartmentCategories::latest()->get();
        return DataTables::of($departments)->addColumn('action', static function ($data) {
            $button = <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <button type="button" id="$data->id" class="btn btn-info btn-sm btnEdit">Edit</button>
                  <button type="button" id="$data->id" class="btn btn-danger btn-sm btnDelete">Delete</button>
               </div>
EOT;
            return $button;
        })->editColumn('created_at', static function ($data) {
            return $data->created_at->format('d, M Y');
        })->rawColumns(['action', 'created_at'])->make(true);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        $error_array = [];
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            DepartmentCategories::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description
            ]);
        }

        $output = [
            'error' => $error_array,
            'success' => true
        ];

        return response()->json($output);
    }


    public function edit($id)
    {
        $department = DepartmentCategories::findOrFail($id);
        return response()->json(['department' => $department]);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        $error_array = [];
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            DepartmentCategories::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description
            ]);
        }

        $output = [
            'error' => $error_array,
            'success' => true
        ];

        return response()->json($output);
    }

    public function kill(Request $request)
    {
        $id = $request->input('id');
        DepartmentCategories::findOrFail($id)->first()->delete();
        return response()->json(['success' => true]);
    }
}
