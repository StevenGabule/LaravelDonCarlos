<?php

namespace App\Http\Controllers;

use App\Mail\ReplyToUser;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class MessageController extends Controller
{
    public function index()
    {
        return view('backend.mails.index');
    }

    public function all(Request $request, $type)
    {
        $articles = null;

        if ($type === 'all') {
            $messages = Message::latest()->get();
        }

        if ($type === 'trash') {
            $messages = Message::onlyTrashed()->get();
        }

        if ($type === 'unread') {
            $messages = Message::where('status', '=', 0)->get();
        }

        if ($type === 'read') {
            $messages = Message::where('status', '=', 1)->get();
        }

        if ($type === 'sent') {
            $messages = Message::where('status', '=', 2)->get();
        }

        return DataTables::of($messages)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "
                        <button class='dropdown-item viewMessage' id='$data->id'>
                            <i class='fad fa-eye mr-2'></i> View
                        </button>
                        <a class='dropdown-item moveTrash' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Move Trash
                        </a>" : "<a class='dropdown-item killArticle' id='$data->id' href='javascript:void(0)'>
                            <i class='fad fa-trash mr-2'></i> Delete
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class='dropdown-item restoreIndMail' id='$data->id' href='javascript:void(0)'>
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
        })->addColumn('checkbox', '<input type="checkbox" name="message_checkbox[]" class="message_checkbox" value="{{$id}}" />')
            ->editColumn('status', function ($data) {
                return $this->state_status($data->status);
            })
            ->editColumn('subject', function ($data) {
                return strlen($data->subject) <= 50 ? $data->subject : substr($data->subject, 0, 45) . '...';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('M d Y') . ', '. $data->created_at->diffForHumans();
            })
            ->rawColumns(['action', 'checkbox', 'status', 'created_at', 'subject'])
            ->make(true);
    }

    public function state_status($status)
    {
        $arr = ["Unread", "Read", "Sent"];
        return $arr[$status];
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'to' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $data = array(
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'status' => 1,
            'file' => $request->hasFile('avatar') ? $request->file('avatar') : null,
            'created_at' => Carbon::now(),
            'subject' => $request->subject,
            'message' => $request->message,
        );

        $arr = explode(",", $request->to);
        $recipients = [];
        $send = [];

        foreach ($arr as $item) {
            $ar = array(
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'to' => trim($item),
                'status' => 1,
                'created_at' => Carbon::now(),
                'subject' => $request->subject,
                'message' => $request->message,
            );
            $send[] = $ar;
            $recipients[] = trim($item);
        }

        Mail::to($recipients)->send(new ReplyToUser($data));
        Message::insert($send);
        return response()->json(['success' => true, 'arr' => $arr]);
    }

    public function fetch(Request $request)
    {
        $term = $request->get('term');
        $mails = Message::select('email')->whereRaw('LOWER(email) LIKE ?', ["%{$term}%"])->get();
        return response()->json(['emails' => $mails]);
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        if ($message->status !== 1 and $message->status) {
            $message->update([
                'status' => 1
            ]);
        }

        return response()->json(['messages' => $message], 200);
    }

    public function remove(Request $request)
    {
        $messagesId = $request->input('id');
        if (is_array($messagesId)) {
            $message = Message::whereIn('id', $messagesId);
            if ($message->delete()) {
                return response()->json(['success' => true], 200);
            }
        }
        Message::where('id', $messagesId)->firstOrFail()->delete();
        return response()->json(['failed' => false]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Message::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => true]);
        }
        Message::withTrashed()->where('id', $ids)->first()->restore();
        return response()->json(['success' => true]);
    }

    public function kill(Request $request)
    {
        $ids = $request->input('id');
        if (is_array($ids)) {
            Message::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['success' => true]);
        }
        Message::withTrashed()->where('id', $ids)->first()->forceDelete();
        return response()->json(['success' => true]);
    }
}
