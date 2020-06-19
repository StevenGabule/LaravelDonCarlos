<?php

namespace App\Http\Controllers;

use App\Baranggay;
use App\baranggayOfficial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BaranggayOfficialController extends Controller
{
    public function index()
    {
        return view('backend.officials.index');
    }

    public function all(Request $request, $type)
    {
        $baranggay = null;
        if ($type === 'all') {
            $baranggay = Baranggay::latest();
        }

        if ($type === 'trash') {
            $baranggay = Baranggay::onlyTrashed()->get();
        }

        if ($type === 'drafted') {
            $baranggay = Baranggay::where('status', '=', 0)->get();
        }

        if ($type === 'published') {
            $baranggay = Baranggay::where('status', '=', 1)->get();
        }

        return DataTables::of($baranggay)->addColumn('action', static function ($data) {
            $btn = ($data->deleted_at === null) ? "<a class=\"dropdown-item removeBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Move Trash  
                        </a>" : "<a class=\"dropdown-item removeBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
                            <i class=\"fad fa-trash mr-2\"></i> Delete 
                        </a>";
            $btnRestore = ($data->deleted_at !== null) ? "<a class=\"dropdown-item restoreBaranggay\" id=\"$data->id\" href=\"javascript:void(0)\">
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
                        <a class="dropdown-item" id="$data->id" href="/admin/article/$data->id/edit"><i class="fad fa-file-edit mr-2"></i> Edit</a>
                        $btn
                        $btnRestore
                    </div>
                </div>
EOT;
            return $button;
        })->addColumn('checkbox', '<input type="checkbox" name="baranggay_checkbox[]" class="baranggay_checkbox" value="{{$id}}" />')
            ->editColumn('avatar', static function ($data) {
                return $data->avatar === null ? '<i class="fad fa-images fa-2x" aria-hidden="true"></i>' : "<img src='/backend/uploads/baranggays/$data->avatar' class='rounded-circle' style='height: 32px;width: 32px' />";
            })
            ->rawColumns(['action', 'checkbox', 'avatar'])
            ->make(true);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\baranggayOfficial  $baranggay_official
     * @return \Illuminate\Http\Response
     */
    public function show(baranggayOfficial $baranggay_official)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\baranggayOfficial  $baranggay_official
     * @return \Illuminate\Http\Response
     */
    public function edit(baranggayOfficial $baranggay_official)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\baranggayOfficial  $baranggay_official
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, baranggayOfficial $baranggay_official)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\baranggayOfficial  $baranggay_official
     * @return \Illuminate\Http\Response
     */
    public function destroy(baranggayOfficial $baranggay_official)
    {
        //
    }
}
