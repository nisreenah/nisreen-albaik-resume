<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Alert;
use App\UserAgent;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users()
    {
        // get all users that was active in the last 24 hours
       return $users_agent = UserAgent::where("created_at", ">", Carbon::now()->subDay())->where("created_at", "<", Carbon::now())->get()->unique('user_id');

        //
        $all_user_agents = UserAgent::where('created_at',Carbon::today())->count();
        dd($all_user_agents);

        $chrome_browser = UserAgent::where('browser', 'like', 'Chrome%')->count();
        $safari_browser = UserAgent::where('browser', 'like', 'Safari%')->count();
        $firefox_browser = UserAgent::where('browser', 'like', 'Firefox%')->count();
        $opera_browser = UserAgent::where('browser', 'like', 'Opera%')->count();
        $mobile = UserAgent::where('device', '!=', 'WebKit')->count();
        $desktop = UserAgent::where('device', '=', 'WebKit')->count();

        $chrome_browser_rate = number_format(($chrome_browser / $all_user_agents) * 100, 2, '.', ',');
        $safari_browser_rate = number_format(($safari_browser / $all_user_agents) * 100, 2, '.', ',');
        $firefox_browser_rate = number_format(($firefox_browser / $all_user_agents) * 100, 2, '.', ',');
        $opera_browser_rate = number_format(($opera_browser / $all_user_agents) * 100, 2, '.', ',');
        $mobile_rate = number_format(($mobile / $all_user_agents) * 100, 2, '.', ',');
        $desktop_rate = number_format(($desktop / $all_user_agents) * 100, 2, '.', ',');

        $users_browsers['chrome_browser_count'] = $chrome_browser;
        $users_browsers['chrome_browser_rate'] = $chrome_browser_rate;
        $users_browsers['safari_browser_count'] = $safari_browser;
        $users_browsers['safari_browser_rate'] = $safari_browser_rate;
        $users_browsers['firefox_browser_count'] = $firefox_browser;
        $users_browsers['firefox_browser_rate'] = $firefox_browser_rate;
        $users_browsers['opera_browser_count'] = $opera_browser;
        $users_browsers['opera_browser_rate'] = $opera_browser_rate;
        $users_browsers['mobile_count'] = $mobile;
        $users_browsers['mobile_rate'] = $mobile_rate;
        $users_browsers['desktop_count'] = $desktop;
        $users_browsers['desktop_rate'] = $desktop_rate;

        return $users_browsers;
        //dd('mobile: ' . $mobile . ' desktop: ' . $desktop);
        //dd('all_user_agents: ' . $all_user_agents . ' chrome_browser: ' . $chrome_browser . ' safari_browser: ' . $safari_browser . ' firefox_browser: ' . $firefox_browser . ' opera_browser: ' . $opera_browser);

        return view('reports.users', compact('users_agent'));
    }

    public function universities()
    {
        return view('reports.universities');
    }

    public function subscriptions()
    {
        return view('reports.subscriptions');
    }

    public function majors()
    {
        return view('reports.majors');
    }

    public function lessons()
    {
        return view('reports.lessons');
    }

    public function departments()
    {
        return view('reports.departments');
    }

    public function chapters()
    {
        return view('reports.chapters');
    }

    public function financial()
    {
        return view('reports.financial');
    }

    public function marketing()
    {
        return view('reports.marketing');
    }

    public function technical()
    {
        return view('reports.technical');
    }

}
