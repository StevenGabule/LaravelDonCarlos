<?php

namespace App\Http\Controllers;

use App\Transparency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransparencyController extends Controller
{
    public function index()
    {
        return view('backend.transparency.index');
    }

    public function all()
    {
        $transparency = Transparency::latest()->get();
        return DataTables::of($transparency)->addColumn('action', static function ($data) {
            $button = <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <button type="button" id="$data->id" class="btn btn-secondary editTransparency btn-info" data-target="modal">Edit</button>
                  <button type="button" id="$data->id" class="btn btn-secondary btnDelete btn-danger">Delete</button>
                </div>
EOT;
            return $button;
        })->rawColumns(['action'])->make(true);

    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Transparency::create([
            'title' => $request->title,
            'short_description' => $request->input('short_description', null)
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $transparency= Transparency::findOrFail($id);
        return response()->json(['transparency' => $transparency], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $transparency = Transparency::findOrFail($id);

        $transparency->update([
            'title' => $request->title,
            'short_description' => $request->input('short_description', null)
        ]);

        return response()->json(['success' => true]);
    }


    public function delete($id)
    {
        Transparency::whereId($id)->delete();
        return response()->json(['success' => true]);
    }
}
