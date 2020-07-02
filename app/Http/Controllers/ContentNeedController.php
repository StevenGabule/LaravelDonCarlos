<?php

namespace App\Http\Controllers;

use App\ContentNeed;
use App\Traits\ImageHandle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ContentNeedController extends Controller
{
    use ImageHandle;

    public function index()
    {
        return view('backend.Award-Mandate.index');
    }

    public function all($type)
    {
        $articles = null;

        if ($type === 'all') {
            $contentNeeds = ContentNeed::latest()->get();
        }

        if ($type === 'trash') {
            $contentNeeds = ContentNeed::onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $contentNeeds = ContentNeed::where('status', 0)->get();
        }

        if ($type === 'published') {
            $contentNeeds = ContentNeed::where('status', 1)->get();
        }

        return DataTables::of($contentNeeds)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/article/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removeArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item' id='$data->id' href='javascript:void(0)'>
                          No action
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash-restore mr-2'></i> Restore
                        </a>" : null;
            $button = <<<EOT
                <div class="dropdown no-arrow" style="width:50px">
                  <a href="javascript:void(0)" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fad fa-ellipsis-h"></i>
                  </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" style="font-size: 13px;">
                        <h6 class="dropdown-header">Actions</h6>
                        $btn
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="content_need[]" class="content_need" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null
                    ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' :
                    "<img src='/backend/uploads/content-needs/small/$data->avatar'  alt='No image' class='rounded-circle' style='height: 32px;width: 32px' />";
            })->editColumn('need_type', function ($data) {
                return $data->need_type == 1 ? 'Award' : 'Mandate';
            })->editColumn('created_at', function ($data) {
                return $data->created_at->format('d, M Y') . ' '.  $data->created_at->diffForHumans();
            })->rawColumns(['action', 'checkbox', 'avatar', 'need_type', 'created_at'])->make(true);
    }

    public function create()
    {
        return view('backend.Award-Mandate.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'need_type' => 'required',
        ]);

        $name = null;
        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'content-needs');
        }

        $content = ContentNeed::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status == 1 ? true : false,
            'avatar' => $name,
            'need_type' => $request->need_type
        ]);

        return response()->json(['id' => $content->id], 200);
    }

    public function edit($id)
    {
        $content = ContentNeed::findOrFail($id);
        return view('backend.Award-Mandate.edit', compact('content'));
    }

    public function update_ajax(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'need_type' => 'required',
        ]);

        $content = ContentNeed::findOrFail($request->input('content_need_id'));
        $name = [];

        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($content->avatar, $originalImage, $name, 'content-needs');
            $content->avatar = $name;
        }

        $content->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status == 1 ? true : false,
            'need_type' => $request->need_type,
            'avatar' => $name,
        ]);

        return response()->json(['updated' => true]);
    }

    public function clone(Request $request)
    {
        $ids = $request->input('id');
        $data = [];
        if (is_array($ids)) {
            $contents = ContentNeed::whereIn('id', $ids)->get();
            foreach ($contents as $content) {
                $temp = [
                    'user_id' => Auth::id(),
                    'title' => $content->title,
                    'slug' => Str::slug($content->title),
                    'short_description' => $content->short_description,
                    'description' => $content->description,
                    'status' => false,
                    'need_type' => $content->need_type,
                    'avatar' => null,
                    'created_at' => Carbon::now()
                ];
                $data[] = $temp;
            }
            ContentNeed::insert($data);
            return response()->json(['content-need' => $contents, 'ids' => $ids, 'data' => $data]);
        }
    }

    public function remove(Request $request)
    {
        $contentIdArray = $request->input('id');
        if (is_array($contentIdArray)) {
            $articles = ContentNeed::whereIn('id', $contentIdArray);
            if ($articles->delete()) {
                return response()->json(['success' => true]);
            }
        }
        ContentNeed::where('id', $contentIdArray)->delete();
        return response()->json(['failed' => false]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            ContentNeed::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        ContentNeed::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $content = ContentNeed::withTrashed()->where('id', $id)->first();
                $this->removeImages($content->avatar, 'content-needs');
                $content->forceDelete();
            }
            return response()->json(['success' => true]);
        }

        $one = ContentNeed::withTrashed()->where('id', $ids)->first()->forceDelete();
        $this->removeImages($one->avatar, 'content-needs');
        return response()->json(['success' => true]);
    }
}
