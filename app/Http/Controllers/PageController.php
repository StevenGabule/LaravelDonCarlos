<?php

namespace App\Http\Controllers;


use App\Activities;
use App\Article;
use App\Services;

class PageController extends Controller
{
    public function index()
    {
        $services = Services::latest()->take(4)->get();
        $news = Article::with('user')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->skip(1)
            ->get();
        
        $latestNews = Article::latest()->first();

        $activities = Activities::latest()->take(3)->skip(1)->get();
        $latestActivity = Activities::latest()->first();
        return view('index', compact('services', 'news', 'activities', 'latestActivity', 'latestNews'));
    }

    public function news_details($slug)
    {
        $news = Article::whereSlug($slug)->first();
        $articles = Article::latest()->take(2)->get();
        return view('show-news', compact('news', 'articles'));
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
