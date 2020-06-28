<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use App\Activities;
use App\Article;
use App\Baranggay;
use App\Message;
use App\Place;
use App\Services;
use App\ServicesArticle;
use App\Transparency;
use App\TransparencyPost;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Don Carlos Official Website');
        SEOTools::setDescription('Don carlos official for news, programs');
        SEOTools::opengraph()->setUrl(env('APP_URL'));
        SEOTools::setCanonical(env('APP_URL'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(env('APP_URL'));
        SEOTools::jsonLd()->addImage('');

        $services = Services::latest()->take(4)->get();
        $news = Article::with('user')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->skip(1)
            ->get();

        $latestNews = Article::latest()->firstOrFail();

        $activities = Activities::latest()->take(3)->skip(1)->get();
        $latestActivity = Activities::latest()->firstOrFail();
        return view('index', compact('services', 'news', 'activities', 'latestActivity', 'latestNews'));
    }

    public function news_details($slug)
    {
        $news = Article::whereSlug($slug)->firstOrFail();
        $articles = Article::latest()->take(2)->get();
        return view('show-news', compact('news', 'articles'));
    }

    public function services()
    {
        $services = Services::latest()->get();
        $articles = Article::latest()->take(2)->get();
        return view('services', compact('services', 'articles'));
    }

    public function services_show($id)
    {
        $serviceArt = ServicesArticle::where('services_id', $id)
            ->orderBy('created_at', 'DESC')
            ->filter(request()->only(['q']))
            ->paginate(5);
        $serviceType = Services::findOrFail($id);
        $services = Services::latest()->get();
        $articles = Article::latest()->take(2)->get();
        return view('services-show', compact('serviceArt', 'services', 'id', 'serviceType', 'articles'));
    }

    public function about()
    {
        $articles = Article::latest()->take(2)->get();
        return view('about', compact('articles'));
    }

    public function about_baranggay()
    {
        $articles = Article::latest()->take(2)->get();
        $baranggays = Baranggay::latest()->filter(request()->only(['q']))->paginate(5);
        return view('about.baranggays', compact('articles', 'baranggays'));
    }

    public function about_baranggay_detail($slug)
    {
        $articles = Article::latest()->take(2)->get();
        $baranggay = Baranggay::whereSlug($slug)->firstOrFail();

        $officials = $baranggay->baranggay_officials()->get();
        return view('about.baranggay_detail', compact('articles', 'baranggay', 'officials'));
    }

    public function service_show_detail($id, $slug)
    {
        $serviceType = Services::findOrFail($id);
        $services = Services::latest()->get();
        $news = ServicesArticle::whereSlug($slug)->firstOrFail();
        $articles = Article::latest()->take(2)->get();
        return view('services-show-detail', compact('serviceType', 'news', 'services', 'id', 'articles'));
    }

    public function transparency()
    {
        $articles = Article::latest()->take(2)->get();
        $transparencies = Transparency::latest()->get();
        return view('transparency', compact('articles', 'transparencies'));
    }

    public function transparencyShow($slug)
    {
        $articles = Article::latest()->take(2)->get();
        $transparent = Transparency::whereSlug($slug)->firstOrFail();
        $transparencies = Transparency::latest()->get();
        $posts = TransparencyPost::where('transparency_id', $transparent->id)->filter(request()->only(['q']))->paginate(10);
        return view('transparency-show', compact('posts', 'articles', 'transparent', 'transparencies', 'slug'));
    }

    public function transparencyDetail($slug1, $slug2)
    {
        $articles = Article::latest()->take(2)->get();
        $transparent = Transparency::whereSlug($slug1)->firstOrFail();
        $post = TransparencyPost::whereSlug($slug2)->firstOrFail();
        $transparencies = Transparency::latest()->get();
        return view('transparency-show-detail',
            compact('articles', 'transparent', 'transparencies', 'post', 'slug1', 'slug2'));
    }

    public function news()
    {
        $news = Article::with('user')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->filter(request()->only(['q']))
            ->paginate(9);
        $articles = Article::latest()->take(2)->get();
        return view('news', compact('news', 'articles'));
    }

    public function tourism()
    {
        $places = Place::where('status', 1)->orderBy('created_at', 'desc')->paginate(9);
        return view('tourism', compact('places'));
    }

    public function tourismShow($slug)
    {
        $relatedPosts = Place::latest()->take(3)->get();
        $place = Place::whereSlug($slug)->firstOrFail();
        return view('tourism-show', compact('place', 'relatedPosts'));
    }

    public function activities()
    {
        $activities = Activities::latest()->orderBy('created_at', 'desc')->skip(1)->paginate(10);
        $upcoming = Activities::latest()->firstOrFail();
        return view('activities', compact('activities', 'upcoming'));
    }

    public function activitiesShowData($slug)
    {
        $relatedPosts = Activities::latest()->take(3)->get();
        $events = Activities::whereSlug($slug)->firstOrFail();
        return view('activities-show', compact('events', 'relatedPosts'));
    }

    public function contacts()
    {
        $articles = Article::latest()->take(2)->get();
        return view('contacts', compact('articles'));
    }

    public function sending(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'subject' => 'required|min:6|max:255',
            'name' => 'required|min:6|max:150',
            'email' => 'required|min:6|max:150',
            'message' => 'required|min:10',
        ]);

        $error_array = [];
        $data = [];

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } else {
            $data = Message::create([
                'subject' => $request->input('subject', 'No subject'),

                'name' => $request->input('name', 'No name'),
                'email' => $request->input('email', 'No email'),
                'message' => $request->input('message', 'No message'),
            ]);
        }

        $output = [
            'errors' => $error_array,
            'msg' => $request->all(),
            'success' => true,
            'data' => $data
        ];

        return response()->json($output, 201);
    }

}
