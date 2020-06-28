<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Traits\ImageHandle;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    use ImageHandle;

    public function index()
    {
        $activities = Activities::latest()->get();

        return view('backend.activities.index', compact('activities'));
    }

    public function all(Request $request, $type)
    {
        $activities = null;
        if ($type === 'all') {
            $activities = Activities::latest();
        }

        if ($type === 'trash') {
            $activities = Activities::onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $activities = Activities::where('status', 0)->get();
        }

        if ($type === 'published') {
            $activities = Activities::where('status', 1)->get();
        }

        return DataTables::of($activities)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <a class='dropdown-item' href='$data->id'><i class='fad fa-eye mr-2'></i> View</a>
                        <a class='dropdown-item' id='$data->id' href='/admin/activities/$data->id/edit'><i class='fad fa-file-edit mr-2'></i> Edit</a>
                        <a class='dropdown-item removeBaranggay' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item removeActivities' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreActivities' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Restore
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
        })->addColumn('checkbox', '<input type="checkbox" name="activity_checkbox[]" class="activity_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='/backend/uploads/activities/small/$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })->editColumn('event_start', static function ($data) {
                return DateTime::createFromFormat('Y-m-d', $data->event_start)->format('M d Y');
            })->editColumn('opening_time', static function ($data) {
                $hour = (int)DateTime::createFromFormat('H:m:s', $data->opening_time)->format('H');
                if ($hour <= 12) {
                    return DateTime::createFromFormat('H:m:s', $data->opening_time)->format('H:i');
                }
                $setHour = $hour - 12;
                return $setHour . DateTime::createFromFormat('H:m:s', $data->opening_time)->format(':i');

            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.activities.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'status' => 'required',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'event_start' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'address' => 'required',
        ]);

        $name = null;
        $act = null;

        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages(null, $originalImage, $name, 'activities');
        }

        $act = Activities::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'user_id' => Auth::id(),
            'event_start' => $request->get('event_start'),
            'opening_time' => $request->get('opening_time'),
            'closing_time' => $request->get('closing_time'),
            'status' => $request->get('status'),
            'avatar' => $name,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
        ]);

        $output = ['id' => $act->id];
        return response()->json($output);
    }

    public function ajaxUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'status' => 'required',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'event_start' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'address' => 'required',
        ]);

        $id = $request->input('activity_id');
        $activities = Activities::findOrFail($id);

        if ($originalImage = $request->file('avatar')) {
            $name = mt_rand() . '.' . $originalImage->getClientOriginalExtension();
            $this->uploadImages($activities->avatar, $originalImage, $name, 'activities');
            $activities->avatar = $name;
        }

        $activities->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'user_id' => Auth::id(),
            'event_start' => $request->get('event_start'),
            'opening_time' => $request->get('opening_time'),
            'closing_time' => $request->get('closing_time'),
            'status' => $request->get('status'),
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['success' => true]);
    }

    public function ajaxUpdateFullCalendar(Request $request)
    {
        $id = (int)$request->Event[0];
        $activity = Activities::where('id', '=', $id)->first();
        $activity->date_start = $request->Event[1];
        $activity->date_end = $request->Event[2];
        $activity->save();
        return response()->json(['data' => $request->Event], 200);
    }

    public function edit(Activities $activity)
    {
        return view('backend.activities.edit', compact('activity'));
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $activity = Activities::withTrashed()->where('id', $id)->first();
                $this->removeImages($activity->avatar, 'activities');
                $activity->forceDelete();
            }
            return response()->json(['success' => true]);
        }
        Activities::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }

    public function massRemove(Request $request)
    {
        $activities = $request->input('id');
        if (is_array($activities)) {
            $actDel = Activities::whereIn('id', $activities);
            if ($actDel->delete()) {
                return response()->json(['success' => true]);
            }
        }
        Activities::where('id', $activities)->first()->delete();
        return response()->json(['failed' => false]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Activities::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        Activities::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function clone(Request $request)
    {
        $ids = $request->input('id');
        $data = [];
        if (is_array($ids)) {
            $activities = Activities::whereIn('id', $ids)->get();
            foreach ($activities as $activity) {
                $temp = [
                    'user_id' => Auth::id(),
                    'title' => $activity->title,
                    'slug' => $activity->slug,
                    'short_description' => $activity->short_description,
                    'description' => $activity->description,
                    'status' => $activity->status,
                    'date_start' => $activity->date_start,
                    'date_end' => $activity->date_end,
                    'address' => $activity->address,
                    'avatar' => null,
                    'created_at' => Carbon::now()
                ];
                $data[] = $temp;
            }
            Activities::insert($data);
            return response()->json(['success' => true], 200);
        }
    }

}
