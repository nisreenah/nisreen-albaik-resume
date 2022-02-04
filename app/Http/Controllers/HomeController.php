<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Contact;
use App\UserAgent;
use Illuminate\Http\Request;
use App\Profile;
use App\Skill;
use App\Service;
use App\Blog;
use App\Category;
use App\Education;
use App\Experience;
use App\Portfolio;
use App\Testimonial;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agent = new Agent();
        //$languages = $agent->languages();
        $device = $agent->device();
        $platform = $agent->platform();
        $platform_version = $agent->version($platform);
        $browser = $agent->browser();
        $browser_version = $agent->version($browser);
        $is_robot = $agent->isRobot() ? 'yes' : 'no';
        $robot = $agent->robot(); // get robot name, if not a robot then return false

        UserAgent::create([
            //'languages' => $languages,
            'device' => $device,
            'platform' => $platform,
            'platform_version' => $platform_version,
            'browser' => $browser,
            'browser_version' => $browser_version,
            'is_robot' => $is_robot,
            'robot' => $robot,
            'ip_address' => request()->ip(),
        ]);

        $profile = Profile::first();
        $skills = Skill::all();
        $services = Service::all();
        $blogs = Blog::all();
        $categories = Category::all();
        $educations = Education::all();
        $experiences = Experience::all();
        $portfolios = Portfolio::all();
        $testimonials = Testimonial::all();

        return view('home', compact('profile', 'skills', 'services', 'blogs', 'categories', 'educations', 'experiences', 'portfolios', 'testimonials'));
    }


    public function postSingle(Blog $blog)
    {
        return view('post-single', compact('blog'));
    }

    public function projectSingle(Portfolio $portfolio)
    {
        return view('project-single', compact('portfolio'));
    }

    public function leaveComment(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
            'blog_id' => 'required',
        ]);

        $inputs = $request->all();
        $add_comment = Comment::create($inputs);
        if ($add_comment) {
            return response()->json(['status' => true, 'title' => 'Thanks, Your comment successfully added', 'text' => 'Your comment will be shown after it is accepted by the admin']);
        } else {
            return response()->json(['status' => false, 'title' => 'Something went wrong!.', 'text'=> 'Your comment was NOT added!']);
        }
    }

    public function getInTouch(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

//        $validator = Validator::make($request->all(), $data);
//
//        // Validate the input and return correct response
//        if ($validator->fails()) {
//            return response()->json([
//                'status' => false,
//                'message' => $validator->getMessageBag()->toArray()
//            ], 422); // 400 being the HTTP code for an invalid request.
//        }

        $inputs = $request->all();
        $create_contact_us = Contact::create($inputs);

        if ($create_contact_us) {
            return response()->json(['status' => true, 'message' => 'Your message was successfully added']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!.']);
        }
    }

}
