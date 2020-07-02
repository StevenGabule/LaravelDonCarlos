<?php

namespace App\Http\Controllers;

use App\Place;
use App\Transparency;
use App\TransparencyFile;
use App\TransparencyPost;
use App\TransparentPostFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TransparencyPostController extends Controller
{
    public function index()
    {
        return view('backend.transparency_posts.index');
    }

    public function all($type)
    {
        if ($type === 'all') {
            $posts = TransparencyPost::with('transparency')->latest()->get();
        }

        if ($type === 'drafted') {
            $posts = TransparencyPost::with('transparency')->where('status', 0)->get();
        }

        if ($type === 'published') {
            $posts = TransparencyPost::with('transparency')->where('status', 1)->get();
        }

        if ($type === 'trash') {
            $posts = TransparencyPost::with('transparency')->onlyTrashed()->get();
        }

        return DataTables::of($posts)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/transparency-posts/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removePost' id='$data->id' href='javascript:void(0)'><i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item kill' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restorePost' id='$data->id' href='javascript:void(0)'>
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
        })->addColumn('checkbox', '<input type="checkbox" name="post_checkbox[]" class="post_checkbox" value="{{$id}}" />')
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function create()
    {
        $transparencies = Transparency::latest()->get();
        $transparentFiles = TransparencyFile::latest()->get();
        return view('backend.transparency_posts.create', compact('transparencies', 'transparentFiles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'transparency_id' => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $post = TransparencyPost::create([
            'title' => $request->get('title'),
            'transparency_id' => $request->get('transparency_id'),
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->get('title')),
            'short_description' => $request->get('short_description', null),
            'description' => $request->get('description', null),
            'status' => $request->get('status', 0),
        ]);

        $data = [];
        if ($request->transparency_file_id) {
            foreach ($request->transparency_file_id as $item) {

                $arr = array(
                    'transparency_file_id' => $item,
                    'transparency_post_id' => $post->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
                $data[] = $arr;
            }
            TransparentPostFile::insert($data);
        }

        $output = ['id' => $post->id];
        return response()->json($output);
    }

    public function update_ajax(Request $request)
    {
        $this->validate($request, [
            'transparency_id' => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $id = $request->input('post_id');
        $post = TransparencyPost::where('id', $id)->firstOrFail();

        $post->update([
            'title' => $request->get('title'),
            'transparency_id' => $request->get('transparency_id'),
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->get('title')),
            'short_description' => $request->get('short_description', null),
            'description' => $request->get('description', null),
            'status' => $request->get('status'),
        ]);


        $data = [];
        if ($request->transparency_file_id) {

            // adding
            foreach ($request->transparency_file_id as $item) {
                $transFile = TransparentPostFile::where('transparency_post_id', $id)->where('transparency_file_id', $item)->exists();
                if ($transFile) {
                    continue;
                }
                $arr = array(
                    'transparency_file_id' => $item,
                    'transparency_post_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
                $data[] = $arr;
            }

            TransparentPostFile::insert($data);

            // deleting if user uncheck some connection files in transparency post
             TransparentPostFile::where('transparency_post_id', $id)
                 ->whereNotIn('transparency_file_id', $request->transparency_file_id)->delete();

        }

        if ($request->transparency_file_id === null) {
            TransparentPostFile::where('transparency_post_id', $id)->delete();
        }

        $output = ['success' => true];
        return response()->json($output);
    }


    public function edit($id)
    {
        $post = TransparencyPost::with('transparency_post_files')->findOrFail($id);
        $transparencies = Transparency::latest()->get();
        $transparentFiles = TransparencyFile::latest()->get();
        return view('backend.transparency_posts.edit', compact('post', 'transparencies', 'transparentFiles'));
    }

    public function massRemove(Request $request)
    {
        $postIds = $request->input('id');
        if (is_array($postIds)) {
            $transparencyPosts = TransparencyPost::whereIn('id', $postIds);
            if ($transparencyPosts->delete()) {
                return response()->json(['success' => true]);
            }
        }

        TransparencyPost::findOrFail($postIds)->delete();
        return response()->json(['failed' => false]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            TransparencyPost::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        TransparencyPost::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            TransparencyPost::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        TransparencyPost::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

}
