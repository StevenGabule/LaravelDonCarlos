<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function services()
    {
        return view('services');
    }

    public function about()
    {
        return view('about');
    }

    public function transparency()
    {
        return view('transparency');
    }

    public function news()
    {
        return view('news');
    }

    public function tourism()
    {
        return view('tourism');
    }

    public function events()
    {
        return view('events');
    }

    public function contacts()
    {
        return view('contacts');
    }

}
