<?php

namespace App\Http\Controllers;

use App\Services;
use App\ServicesArticle;
use App\Traits\ImageHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class ServicesArticleController extends Controller
{
    use ImageHandle;

    public function index()
    {
        return view('backend.services-articles.index');
    }

    public function all(Request $request, $type)
    {
        $serviceArticles = null;

        if ($type === 'all') {
            $serviceArticles = ServicesArticle::with('category')->orderByDesc('created_at')
                ->get();
        }

        if ($type === 'trash') {
            $serviceArticles = ServicesArticle::with('category')
                ->onlyTrashed()
                ->orderByDesc('created_at')
                ->get();
        }

        if ($type === 'drafted') {
            $serviceArticles = ServicesArticle::with('category')
                ->where('status', '=', 0)
                ->orderByDesc('created_at')
                ->get();
        }

        if ($type === 'published') {
            $serviceArticles = ServicesArticle::with('category')
                ->where('status', '=', 1)
                ->orderByDesc('created_at')
                ->get();
        }

        return DataTables::of($serviceArticles)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class=\"dropdown-item\" href=\"$data->id\"><i class=\"fad fa-eye mr-2\"></i> View</a>
                        <a class=\"dropdown-item\" id=\"$data->id\" href=\"/admin/service-article/$data->id/edit\"><i class=\"fad fa-file-edit mr-2\"></i> Edit</a><a class=\"dropdown-item removeServiceArticle\" id=\"$data->id\" href=\"javascript:void(0)\">
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
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="serviceArticle_checkbox[]" class="serviceArticle_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
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
            'name' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'service_id' => 'required',
        ]);

        $image_url = null;

        if ($request->file('avatar')) {
            /*$name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'service-article');*/
            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        }

        $sa = ServicesArticle::create([
            'user_id' => Auth::id(),
            'services_id' => $request->get('service_id'),
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'status' => $request->get('status'),
            'avatar' => $image_url,
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
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'service_id' => 'required',
        ]);

        $serviceArticle = ServicesArticle::findOrFail($request->input('service_article_id'));

        if ($request->file('avatar')) {
            /* $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($serviceArticle->avatar, $originalImage, $name, 'service-article');
            $serviceArticle->avatar = $name; */
            if ($serviceArticle->avatar !== null) {
                $splits = explode('/', $serviceArticle->avatar)[7];
                $publicId = explode('.', $splits)[0];
                Cloudder::delete($publicId, null);
            }

            $image = $request->file('avatar')->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $serviceArticle->avatar = $image_url;
        }

        $serviceArticle->name = $request->get('name');
        $serviceArticle->short_description = $request->get('short_description');
        $serviceArticle->description = $request->get('description');
        $serviceArticle->services_id = $request->get('service_id');
        $serviceArticle->slug = Str::slug($request->get('name'));
        $serviceArticle->status = $request->get('status');
        $serviceArticle->save();

        return response()->json(['success' => true]);
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

    public function kill($ids)
    {
        /*$ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $art = ServicesArticle::withTrashed()->where('id', $id)->first();
                $this->removeImages($art->avatar, 'service-article');
                $art->forceDelete();
            }
            return response()->json(['success' => true]);
        }
        $one = ServicesArticle::withTrashed()->where('id', $ids)->first();
        $this->removeImages($one->avatar, 'service-article');
        $one->forceDelete();*/
        $ids = explode(",", $ids);
        foreach ($ids as $id) {
            $service_article = ServicesArticle::withTrashed()->where('id', $id)->first();
            $splits = explode('/', $service_article->avatar)[7];
            $publicId = explode('.', $splits)[0];
            Cloudder::delete($publicId, null);
            $service_article->forceDelete();
        }
        return response()->json(['success' => true]);
    }

    public function massRemove(Request $request)
    {
        $serviceArticleID = $request->input('id');
        if (is_array($serviceArticleID)) {
            $serviceArticles = ServicesArticle::whereIn('id', $serviceArticleID);
            if ($serviceArticles->delete()) {
                return response()->json(['success' => true, 'msg' => 'Service article has been moved to trash']);
            }
        }
        ServicesArticle::where('id', $serviceArticleID)->first()->delete();
        return response()->json(['success' => true, 'msg' => 'Service article has been moved to trash']);

    }
}
