<?php

namespace App\Http\Controllers;

use App\TransparencyFile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;
use Yajra\DataTables\DataTables;

class TransparencyFileController extends Controller
{
  public function index()
  {
    return view('backend.transparency_uploads.index');
  }

  public function render()
  {
    $files = TransparencyFile::orderByDesc('created_at')->get();
    return DataTables::of($files)->addColumn('action', static function ($data) {
      $file = asset('/backend/uploads/files/' . $data->filename);
      return <<<EOT
               <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <a href="$file" target='_blank' class="btn btn-info btn-sm" data-toggle="tooltip" title="Click to download">
                    <i class="fad fa-cloud-download"></i>
                  </a>
                  <button type="button" id="$data->id" class="btn btn-danger btn-sm btnDelete">
                    <i class="fad fa-trash-alt"></i>
                  </button>
               </div>
EOT;
    })
      ->addColumn('checkbox', '<input type="checkbox" name="file_checkbox[]" class="file_checkbox" value="{{$id}}" />')
      ->editColumn('created_at', static function ($data) {
        return $data->created_at->format('M d Y') . ', ' . $data->created_at->diffForHumans();
      })->editColumn('size', function ($data) {
        return $this->formatSizeUnits($data->size);
      })->rawColumns(['action', 'created_at', 'checkbox', 'size'])->make(true);
  }

  public function formatSizeUnits($bytes)
  {
    if ($bytes >= 1073741824) {
      $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
      $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
      $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
      $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
      $bytes = $bytes . ' byte';
    } else {
      $bytes = '0 bytes';
    }

    return $bytes;
  }

  public function create()
  {
    return view('backend.transparency_uploads.create');
  }

  public function store(Request $request): JsonResponse
  {
    $uploadedFile = $request->file('file');
    $file_url = null;

    $file = $request->file('file');
    $filePath = $request->file('file')->store('files', 'public');

    $file->getPathName();
    $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($file->getClientOriginalName()));
    $filename = $filePath;
//    $file->storeAs('uploads/transparent_files', $filename, 'tmp');

    TransparencyFile::create([
      'name' => $uploadedFile->getClientOriginalName(),
      'filename' => $filename,
      'file_url' => $file_url,
      'size' => $uploadedFile->getSize(),
      'type' => $uploadedFile->getClientOriginalExtension(),
      'user_id' => Auth::id(),
      'created_at' => Carbon::now()
    ]);

    $uploadedFile->move(public_path() . '/backend/uploads/files/', $filename);
    $original_file = storage_path() . "/uploads/transparent_files/". $filename;
    if (Storage::disk('public')->put("uploads/transparent_files/$filename", fopen($original_file, 'r+'))) {
      File::delete($original_file);
    }
    return response()->json(['success' => true], 200);
  }

  public function mass_remove($ids)
  {

    $ids = explode(",", $ids);
    foreach ($ids as $id) {
      $file = TransparencyFile::where('id', $id)->firstOrFail();
      $file->forceDelete();
    }
    return response()->json(['success' => true], 200);
  }
}
