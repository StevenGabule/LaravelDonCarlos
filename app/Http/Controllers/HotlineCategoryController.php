<?php

namespace App\Http\Controllers;

use App\Hotline;
use App\HotlineCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class HotlineCategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.hotlines.category.create');
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
        $this->validate($request, ['name' => 'required']);
        HotlineCategory::create($request->only('name'));
        return redirect()->route('hotlines.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HotlineCategory $hotlines_category
     * @return Application|Factory|View
     */
    public function edit(HotlineCategory $hotlines_category)
    {
        return view('backend.hotlines.category.edit', compact('hotlines_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HotlineCategory $hotlines_category
     * @return RedirectResponse
     */
    public function update(Request $request, HotlineCategory $hotlines_category)
    {
        $hotlines_category->update($request->only('name'));
        return redirect()->route('hotlines.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HotlineCategory $hotlines_category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(HotlineCategory $hotlines_category)
    {
        Hotline::where('hotline_category_id', $hotlines_category->id)->delete();
        $hotlines_category->delete();

        return redirect()->route('hotlines.index');
    }
}
