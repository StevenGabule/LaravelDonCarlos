<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.news.index');
    }

    public function all(Request $request, $type)
    {
        $articles = null;

        if ($type === 'all') {
            $articles = Article::with('category')->orderByDesc('created_at');
        }

        if ($type === 'trash') {
            $articles = Article::with('category')->onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $articles = Article::with('category')->where('status', '=', 0)->get();
        }

        if ($type === 'published') {
            $articles = Article::with('category')->where('status', '=', 1)->get();
        }

        return DataTables::of($articles)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/article/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removeArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash  
                        </a>" : "<a class='dropdown-item killArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete 
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
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="article_checkbox[]" class="article_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null
                    ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' :
                    "<img src='/backend/uploads/articles/$data->avatar'  alt='No image' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function massRemove(Request $request)
    {
        $articleIdArray = $request->input('id');
        $articles = Article::whereIn('id', $articleIdArray);
        if ($articles->delete()) {
            return response()->json(['success' => true, 'msg' => 'Article has been moved to trash']);
        }
        return response()->json(['failed' => false, 'msg' => 'Error has been composed']);
    }

    public function create()
    {
        $categories = \App\ArticleCategory::all();
        return view('backend.news.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $new_name = null;

        $error_array = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($image = $request->file('avatar')) {
                $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads/articles'), $new_name);
            }

            $article = Article::create([
                'user_id' => Auth::id(),
                'title' => $request->get('title'),
                'slug' => Str::slug($request->get('title')),
                'status' => $request->get('status'),
                'avatar' => $new_name,
                'short_description' => $request->get('short_description'),
                'description' => $request->get('description'),
                'category_id' => $request->get('category_id'),
            ]);
        }
        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $article->id
        ];
        return response()->json($output);
    }


    public function edit($id)
    {
        $categories = \App\ArticleCategory::all();
        $article = Article::findOrFail($id);
        return view('backend.news.edit', compact('article', 'categories'));
    }

    public function updateAjax(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $article = Article::findOrFail($request->input('article_id'));

        $error_array = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->file('avatar')) {
                $image = $request->file('avatar');
                $new_name = mt_rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads/articles'), $new_name);
                $article->avatar = "backend/uploads/articles/$new_name";
            }
            $article->title = $request->get('title');
            $article->slug = Str::slug($request->get('title'));
            $article->description = $request->get('description');
            $article->short_description = $request->get('short_description');
            $article->category_id = $request->get('category_id');
            $article->status = $request->get('status');
            $article->save();
        }
        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $article->id
        ];
        return response()->json($output);
    }

    public function update(Request $request, article $article)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $articleUpdate = 0;

        $error_array = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->file('avatar')) {
                $image = $request->file('avatar');
                $new_name = 'backend/uploads/' . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/uploads'), $new_name);
                $articleUpdate->avatar = $new_name;
            }
            $article->title = $request->get('title');
            $article->description = $request->get('description');
            $article->category_id = $request->get('category_id');
            $article->slug = Str::slug($request->get('slug'));
            $article->status = 1;
            $article->save();
        }
        $output = [
            'error' => $error_array,
            'success' => true,
            'id' => $article->id
        ];
        return response()->json($output);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article) {
            $article->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['failed' => true]);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Article::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        Article::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Article::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        Article::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function clone(Request $request)
    {
        $ids = $request->input('id');
        $data = [];
        if (is_array($ids)) {
            $articles = Article::whereIn('id', $ids)->get();
            foreach ($articles as $article) {
                $temp = ['user_id' => Auth::id(),
                    'title' => $article->title,
                    'short_description' => $article->short_description,
                    'description' => $article->description,
                    'slug' => $article->slug,
                    'status' => $article->status,
                    'avatar' => $article->avatar,
                    'category_id' => $article->category_id,
                    'deleted_at' => $article->deleted_at,
                    'created_at' => Carbon::now()
                ];
                $data[] = $temp;
            }
            Article::insert($data);
            return response()->json(['articles' => $articles, 'ids' => $ids, 'data' => $data]);
        }
    }
}
