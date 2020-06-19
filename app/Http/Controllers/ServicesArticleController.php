<?php

namespace App\Http\Controllers;

use App\Article;
use App\Services;
use App\servicesArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ServicesArticleController extends Controller
{
    public function index()
    {
        return view('backend.services-articles.index');
    }
    public function all(Request $request, $type)
    {
        $serviceArticles = null;

        if ($type === 'all') {
            $serviceArticles = ServicesArticle::with('category')->latest();
        }

        if ($type === 'trash') {
            $serviceArticles = ServicesArticle::with('category')->onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $serviceArticles = ServicesArticle::with('category')->where('status', '=', 0)->get();
        }

        if ($type === 'published') {
            $serviceArticles = ServicesArticle::with('category')->where('status', '=', 1)->get();
        }

        return DataTables::of($serviceArticles)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "<a class=\"dropdown-item removeArticle\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Move Trash  
                        </a>" : "<a class=\"dropdown-item killServiceSA\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Delete 
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class=\"dropdown-item restoreServiceSA\" id=\"$data->id\" href=\"javascript:void(0)\">
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
                        <a class="dropdown-item" id="$data->id" href="/admin/service-article/$data->id/edit"><i class="fad fa-file-edit mr-2"></i> Edit</a>
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="serviceArticle_checkbox[]" class="serviceArticle_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='/$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function create()
    {
        $categories = Services::all();
        return view('backend.services-articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:6|max:100',
            'status' => 'required',
            'short_description' => 'required|min:6|max:100',
            'description' => 'required',
            'service_id' => 'required',
        ]);

        $new_name = null;

        if ($image = $request->file('avatar')) {
            $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/uploads/service-article'), $new_name);
            $new_name = "backend/uploads/service-article/$new_name";
        }

        $sa = ServicesArticle::create([
            'user_id' => Auth::id(),
            'services_id' => $request->get('service_id'),
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'status' => $request->get('status'),
            'avatar' => $new_name,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
        ]);

        return response()->json(['success' => true, 'id' => $sa->id]);
    }

    public function edit($id)
    {
        $sa = ServicesArticle::findOrFail($id);
        $categories = Services::all();
        return view('backend.services-articles.edit', compact('sa', 'categories'));
    }

    public function updateAjax(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:6|max:100',
            'status' => 'required',
            'short_description' => 'required|min:6|max:100',
            'description' => 'required',
            'service_id' => 'required',
        ]);

        $serviceArticle = ServicesArticle::findOrFail($request->input('service_article_id'));

        $error_array = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->file('avatar')) {
                $image = $request->file('avatar');
                $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads/service-article'), $new_name);
                $serviceArticle->avatar = "backend/uploads/service-article/$new_name";
            }
            $serviceArticle->name = $request->get('name');
            $serviceArticle->short_description = $request->get('short_description');
            $serviceArticle->description = $request->get('description');
            $serviceArticle->services_id = $request->get('service_id');
            $serviceArticle->slug = Str::slug($request->get('name'));
            $serviceArticle->status = $request->get('status');
            $serviceArticle->save();
        }
        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $serviceArticle->id
        ];
        return response()->json($output);
    }

    public function update(Request $request)
    {
        return response()->json([]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            ServicesArticle::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        ServicesArticle::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\servicesArticle  $services_article
     * @return \Illuminate\Http\Response
     */
    public function destroy(servicesArticle $services_article)
    {
        //
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            ServicesArticle::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        ServicesArticle::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function massRemove(Request $request)
    {
        $serviceArticleID = $request->input('id');
        $serviceArticles = ServicesArticle::whereIn('id', $serviceArticleID);
        if ($serviceArticles->delete()) {
            return response()->json(['success' => true, 'msg' => 'Service article has been moved to trash']);
        }
        return response()->json(['failed' => false, 'msg' => 'Error has been composed']);
    }
}
