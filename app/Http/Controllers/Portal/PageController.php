<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\LpPage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): View|Factory|Application
    {
        $pages = LpPage::latest()->with('titles')->paginate();

        return view('pages.index', compact('pages'));
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
     * @param  \App\Models\LpPage  $lpPage
     * @return \Illuminate\Http\Response
     */
    public function show(LpPage $lpPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LpPage  $lpPage
     * @return \Illuminate\Http\Response
     */
    public function edit(LpPage $lpPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LpPage  $lpPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LpPage $lpPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LpPage  $lpPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(LpPage $lpPage)
    {
        //
    }
}
