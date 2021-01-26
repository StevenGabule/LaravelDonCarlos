<?php

namespace App\Http\Controllers;

use App\{Hotline, HotlineCategory};
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class HotlineController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $hotlines = Hotline::all();
        $hotlineCategory = HotlineCategory::all();
        return view('backend.hotlines.index', compact('hotlines', 'hotlineCategory'));
    }

    public function create()
    {
        $hotline_category = HotlineCategory::all();
        return view('backend.hotlines.number.create', compact('hotline_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required',
            'hotline_category_id' => 'required',
        ]);

        Hotline::create($request->only('phone_number', 'hotline_category_id'));
        return redirect()->route('hotlines.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hotline $hotline
     * @return Application|Factory|View
     */
    public function edit(Hotline $hotline)
    {
        $hotline_category = HotlineCategory::all();
        return view('backend.hotlines.number.edit', compact('hotline', 'hotline_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Hotline $hotline
     * @return RedirectResponse
     */
    public function update(Request $request, Hotline $hotline)
    {
        $hotline->update($request->only('phone_number', 'hotline_category_id'));
        return redirect()->route('hotlines.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hotline $hotline
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Hotline $hotline)
    {
        $hotline->delete();
        return redirect()->route('hotlines.index');
    }
}
