<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }

    public function users()
    {
        return view('backend.accounts.index');
    }

    public function all()
    {
        $users = User::all();
        return DataTables::of($users)->addColumn('action', static function ($data) {
            $button = <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <button type="button" id="$data->id" class="btn btn-info btn-sm btnEdit">Edit</button>
                  <button type="button" id="$data->id" class="btn btn-primary btn-sm btnChangePassword">Change Password</button>
                  <button type="button" id="$data->id" class="btn btn-danger btn-sm btnDelete">Delete</button>
               </div>
EOT;
            return $button;
        })->editColumn('created_at', static function ($data) {
            return $data->created_at->format('d, M Y');
        })->rawColumns(['action', 'created_at'])->make(true);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:6|max:100',
            'email' => 'required|min:6|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);
        $error_array = [];
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
            return response()->json(['errors' => $error_array, 'success' => false]);

        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        $output = ['success' => true];

        return response()->json($output);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function update(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|min:6|max:100',
            'email' => 'required|min:6|email',
        ]);

        $error_array = [];

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
            return response()->json(['errors' => $error_array, 'success' => false]);

        } else {
            $id = $request->userEditId;
            $user = User::where('id', $id)->firstOrFail();
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        $output = ['success' => true];

        return response()->json($output);
    }

    public function update_password(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed'
        ]);

        $error_array = [];

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
            return response()->json(['errors' => $error_array, 'success' => false]);

        } else {
            $id = $request->userEditPasswordId;
            $user = User::where('id', $id)->firstOrFail();
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $output = ['success' => true];

        return response()->json($output);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }
}
