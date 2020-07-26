<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Article;
use App\Baranggay;
use App\ContentNeed;
use App\DepartmentCategories;
use App\DepartmentOffices;
use App\Message;
use App\PageContent;
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
        /*SEOTools::opengraph()->setUrl(env('APP_URL'));
        SEOTools::setCanonical(env('APP_URL'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(env('APP_URL'));
        SEOTools::jsonLd()->addImage('');*/

        $services = Services::select('id', 'name', 'short_description')->latest()->get();
        $news = Article::with('user:id,name,created_at')
            ->select('id', 'user_id', 'title', 'short_description', 'slug', 'avatar', 'created_at')
            ->where('status', 1)
            ->where('important', false)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->skip(1)
            ->get();

        $newsImportant = Article::where('important', true)->limit(2)->get();
        $latestNews = Article::latest()->first();

        $contents = PageContent::whereIn('id', [1,2])->get();

        $infrastructure = PageContent::where('id', 5)->first();
        $agriculture = PageContent::where('id', 6)->first();
        $healthcare = PageContent::where('id', 7)->first();
        $education = PageContent::where('id', 8)->first();
        $tourism = PageContent::where('id', 9)->first();

        $newHeadLine = Article::where('status', 1)->latest()->first();
        $eventHeadLine = Activities::where('status', 1)->latest()->firstOrFail();
        $placeHeadLine = Place::where('status', 1)->latest()->first();

        $activities = Activities::where('status', 1)->latest()->take(3)->skip(1)->get();
        $latestActivity = Activities::where('status', 1)->latest()->first();

        return view('index', compact(
            'services',
            'news',
            'contents',
            'infrastructure',
            'agriculture',
            'healthcare',
            'education',
            'tourism',
            'newHeadLine',
            'eventHeadLine',
            'placeHeadLine',
            'activities',
            'latestActivity',
            'latestNews',
            'newsImportant'
        ));
    }

    public function news_details($slug)
    {
        $news = Article::whereSlug($slug)->firstOrFail();

        SEOTools::setTitle($news->title);
        SEOTools::setDescription($news->short_description);
//        SEOTools::jsonLd()->addImage($news->avatar);

        $services = Services::latest()->get();
        $articles = Article::latest()->take(2)->get();
        return view('show-news', compact('news', 'articles', 'services'));
    }

    public function services()
    {
        $services = Services::latest()->get();

        SEOTools::setTitle('Services - Government Of Don Carlos');
        SEOTools::setDescription('Services of don carlos bukidnon');

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

        SEOTools::setTitle($serviceType->name);
        SEOTools::setDescription($serviceType->short_description);

        return view('services-show', compact('serviceArt', 'services', 'id', 'serviceType', 'articles'));
    }

    public function about()
    {
        SEOTools::setTitle('Engage more in our government of Don Carlos');
        SEOTools::setDescription('Learn and explore our government here in Don Carlos Bukidnon');
        $articles = Article::latest()->take(2)->get();
        $services = Services::latest()->get();
        $content = PageContent::findOrFail(3);
        $content1 = PageContent::findOrFail(4);
        return view('about', compact('articles', 'services', 'content', 'content1'));
    }

    public function about_baranggay()
    {
        $articles = Article::latest()->take(2)->get();

        $content = PageContent::findOrFail(3);
        $content1 = PageContent::findOrFail(4);

        SEOTools::setTitle('Baranggay of Don Carlos');
        SEOTools::setDescription('List of all the baranggay in don carlos');
        $type = 'baranggay';
        $services = Services::latest()->get();
        $baranggays = Baranggay::latest()->filter(request()->only(['q']))->paginate(5);
        return view('about.baranggays', compact('articles', 'baranggays', 'services', 'content', 'content1', 'type'));
    }

    public function about_baranggay_detail($slug)
    {
        $articles = Article::latest()->take(2)->get();
        $baranggay = Baranggay::whereSlug($slug)->firstOrFail();

        SEOTools::setTitle($baranggay->name);
        SEOTools::setDescription($baranggay->short_description);

        $services = Services::latest()->get();
        $officials = $baranggay->baranggay_officials()->get();
        return view('about.baranggay_detail', compact('articles', 'baranggay', 'officials', 'services'));
    }

    public function service_show_detail($id, $slug)
    {
        $serviceType = Services::findOrFail($id);
        $services = Services::latest()->get();
        $news = ServicesArticle::whereSlug($slug)->firstOrFail();

        SEOTools::setTitle($news->name);
        SEOTools::setDescription($news->short_description);

        $articles = Article::latest()->take(2)->get();
        return view('services-show-detail', compact('serviceType', 'news', 'services', 'id', 'articles'));
    }

    public function transparency()
    {
        $articles = Article::latest()->take(2)->get();
        $transparencies = Transparency::latest()->get();

        SEOTools::setTitle('Transparency - Government Of Don Carlos');
        SEOTools::setDescription('Update and trasparency plan and programs in Don carlos');

        $services = Services::latest()->get();
        return view('transparency', compact('articles', 'transparencies', 'services'));
    }

    public function transparencyShow($slug)
    {
        $articles = Article::latest()->take(2)->get();
        $transparent = Transparency::whereSlug($slug)->firstOrFail();
        $transparencies = Transparency::latest()->get();

        SEOTools::setTitle($transparent->title);
        SEOTools::setDescription($transparent->short_description);

        $services = Services::latest()->get();
        $posts = TransparencyPost::where('transparency_id', $transparent->id)->filter(request()->only(['q']))->paginate(10);
        return view('transparency-show', compact('posts', 'services', 'articles', 'transparent', 'transparencies', 'slug'));
    }

    public function transparencyDetail($slug1, $slug2)
    {
        $articles = Article::latest()->take(2)->get();
        $transparent = Transparency::whereSlug($slug1)->firstOrFail();
        $post = TransparencyPost::whereSlug($slug2)->firstOrFail();
        $transparencies = Transparency::latest()->get();

        SEOTools::setTitle($post->title);
        SEOTools::setDescription($post->short_description);

        $services = Services::latest()->get();
        return view(
            'transparency-show-detail',
            compact('articles', 'services', 'transparent', 'transparencies', 'post', 'slug1', 'slug2')
        );
    }

    public function news()
    {
        $news = Article::with('user')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->filter(request()->only(['q']))
            ->paginate(9);
        $articles = Article::latest()->take(2)->get();
        $services = Services::latest()->get();

        SEOTools::setTitle('News and updates - Government of Don Carlos');
        SEOTools::setDescription('Read, download and engage in the don carlos news');

        return view('news', compact('news', 'services', 'articles'));
    }

    public function tourism()
    {
        $places = Place::where('status', 1)->orderBy('created_at', 'desc')->paginate(9);

        SEOTools::setTitle('Tourism in Government of Don Carlos');
        SEOTools::setDescription('View all the good place and changes in don carlos');
        $services = Services::latest()->get();

        $placeSlides = Place::latest()->take(3)->get();
        return view('tourism', compact('places', 'services', 'placeSlides'));
    }

    public function tourismShow($slug)
    {
        $relatedPosts = Place::latest()->take(3)->get();
        $place = Place::whereSlug($slug)->firstOrFail();

        SEOTools::setTitle($place->name);
        SEOTools::setDescription($place->short_description);
        SEOTools::jsonLd()->addImage($place->avatar);
        $services = Services::latest()->get();
        return view('tourism-show', compact('place', 'relatedPosts', 'services'));
    }

    public function activities()
    {
        $activities = Activities::latest()->orderBy('created_at', 'desc')->skip(1)->paginate(10);
        $upcoming = Activities::latest()->firstOrFail();
        $services = Services::latest()->get();

        SEOTools::setTitle('Events And Activities - Government of Don Carlos Bukidnon');
        SEOTools::setDescription('Don carlos bukidnon upcoming events and activities');
        return view('activities', compact('activities', 'upcoming', 'services'));
    }

    public function activitiesShowData($slug)
    {
        $relatedPosts = Activities::latest()->take(3)->get();
        $events = Activities::whereSlug($slug)->firstOrFail();
        SEOTools::setTitle($events->title);
        SEOTools::setDescription($events->short_description);
        $services = Services::latest()->get();

        return view('activities-show', compact('events', 'relatedPosts', 'services'));
    }

    public function contacts()
    {
        $articles = Article::latest()->take(2)->get();
        SEOTools::setTitle('Contact us - Government of Don Carlos Bukidnon');
        SEOTools::setDescription('Send message - Government of don carlos Bukidnon');
        $services = Services::latest()->get();

        return view('contacts', compact('articles', 'services'));
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

    public function departments()
    {
        $departments = DepartmentCategories::all();
        $articles = Article::latest()->take(2)->get();
        $services = Services::latest()->get();

        SEOTools::setTitle('Departments - Government of Don Carlos Bukidnon');
        SEOTools::setDescription('List of all departments - Government of don carlos Bukidnon');
        return view('departments', compact('departments', 'articles', 'services'));
    }

    public function department_lists($id, $slug)
    {
        $departments = DepartmentCategories::all();
        $department = DepartmentCategories::whereSlug($slug)->firstOrFail();
        $offices = DepartmentOffices::where('department_category_id', $id)->get();

        SEOTools::setTitle($department->name);
        SEOTools::setDescription($department->description);

        $services = Services::latest()->get();
        $articles = Article::latest()->take(2)->get();

        return view('departments-show', compact('departments', 'articles', 'offices', 'id', 'department', 'slug', 'services'));
    }

    public function department_list_show($id, $slug1, $slug2)
    {
        $departments = DepartmentCategories::all();
        $department = DepartmentCategories::whereSlug($slug1)->firstOrFail();
        $office = DepartmentOffices::whereSlug($slug2)->firstOrFail();
        $articles = Article::latest()->take(2)->get();

        $services = Services::latest()->get();
        SEOTools::setTitle($office->name);
        SEOTools::setDescription($office->short_description);

        return view('departments-show-detail', compact('departments', 'articles', 'office', 'id', 'department', 'services'));
    }

    public function page_show($slug)
    {
        $content = PageContent::whereSlug($slug)->firstOrFail();
        SEOTools::setTitle('Don Carlos - '. $content->title);
        SEOTools::setDescription($content->short_description);
        $relatedPosts = Place::latest()->take(3)->get();
        $services = Services::latest()->get();
        return view('page-show', compact('content', 'relatedPosts', 'services'));
    }

    public function award()
    {
        $type = 'awards';
        $content = PageContent::findOrFail(3);
        $content1 = PageContent::findOrFail(4);
        $articles = Article::latest()->take(2)->get();
        $awards = ContentNeed::where('status', true)->where('deleted_at', '=', null)->where('need_type', 1)->orderBy('created_at', 'DESC')->filter(request()->only(['q']))->paginate(5);
        $services = Services::latest()->get();
        return view('award', compact('articles', 'awards', 'services', 'type', 'content', 'content1'));
    }

    public function mandate()
    {
        $type = 'mandate';
        $content = PageContent::findOrFail(3);
        $content1 = PageContent::findOrFail(4);
        $articles = Article::latest()->take(2)->get();
        $awards = ContentNeed::where('status', true)->where('deleted_at', '=', null)->where('need_type', 2)->orderBy('created_at', 'DESC')->filter(request()->only(['q']))->paginate(5);
        $services = Services::latest()->get();
        return view('award', compact('articles', 'awards', 'services', 'type', 'content', 'content1'));
    }

    public function content_show($type, $slug)
    {
        $content = ContentNeed::whereSlug($slug)->firstOrFail();
        $content1 = PageContent::findOrFail(4);
        $articles = Article::latest()->take(2)->get();
        $services = Services::latest()->get();
        return view('award-details', compact('content', 'articles', 'content1', 'type', 'services'));
    }
}
