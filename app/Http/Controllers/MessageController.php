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
            $messages = Message::with('user')->latest()->get();
        }

        if ($type === 'trash') {
            $messages = Message::with('user')->onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $messages = Message::with('user')->where('status', '=', 0)->get();
        }

        if ($type === 'published') {
            $messages = Message::with('user')->where('status', '=', 1)->get();
        }
        #0-unread|1-read

        return DataTables::of($messages)->addColumn('action', static function ($data) {
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
        })->addColumn('checkbox', '<input type="checkbox" name="message_checkbox[]" class="message_checkbox" value="{{$id}}" />')
           ->editColumn('status', function($data) {
               return $this->state_status($data->status);
           })
            ->editColumn('subject', function($data) {
                return strlen($data->subject) <= 50 ? $data->subject : substr($data->subject, 0, 45) . '...';
            })
            ->editColumn('created_at', function($data) {
                return $data->created_at->diffForHumans();
            })
            ->rawColumns(['action', 'checkbox', 'status', 'created_at', 'subject'])
            ->make(true);
    }

    public function state_status($status)
    {
        $arr = ["Unread", "Read"];
        return $arr[$status];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'to' => $request->to,
            'status' => 1,
            'file' => $request->file('avatar'),
            'created_at' => Carbon::now(),
            'subject' => $request->subject,
            'message' => $request->message,
        );
        Mail::to($request->to)->send(new ReplyToUser($data));

        Message::create([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'to' => $request->to,
            'status' => 1,
            'created_at' => Carbon::now(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
