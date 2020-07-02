<?php

namespace App\Http\Controllers;

use App\Article;
use App\DepartmentCategories;
use App\PageContent;
use App\Traits\ImageHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;

class PageContentController extends Controller
{
    use ImageHandle;

    public function index()
    {
        return view('backend.page_content.index');
    }

    public function all()
    {
        $pageContent = PageContent::latest()->get();
        return DataTables::of($pageContent)->addColumn('action', static function ($data) {
            $button = <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <a href="page-content/$data->id/edit" id="$data->id" class="btn btn-info btn-sm btnEdit">Edit</a>
               </div>
EOT;
            return $button;
        })->editColumn('created_at', static function ($data) {
            return $data->created_at->format('d, M Y');
        })->editColumn('avatar', static function ($data) {
            return $data->avatar === null ? "<i class='fad fa-images'></i>" : "<img src=\"/backend/uploads/page-content/small/{$data->avatar}\" class='rounded-circle' />";
        })->rawColumns(['action', 'created_at','avatar'])->make(true);
    }

    public function create()
    {
        return view('backend.page_content.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $name = null;

        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'page-content');
        }

        $pageContent = PageContent::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'avatar' => $name,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
        ]);

        $output = ['id' => $pageContent->id];
        return response()->json($output);
    }

    public function edit($id)
    {
        $page_content = PageContent::findOrFail($id);
        return view('backend.page_content.edit', compact('page_content'));
    }

    public function update_ajax(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $pageContent = PageContent::findOrFail($request->input('page_content_id'));

        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($pageContent->avatar, $originalImage, $name, 'page-content');
            $pageContent->avatar = $name;
        }

        $pageContent->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'short_description' => $request->get('short_description'),
        ]);

        return response()->json(['updated' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PageContent  $pageContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageContent $pageContent)
    {
        //
    }
}
