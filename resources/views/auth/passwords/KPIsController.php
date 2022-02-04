<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Alert;

class ReportsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

	/*
	    Route::get('/users', 'ReportsController@users')->name('reports.users');
    Route::get('/universities', 'ReportsController@universities')->name('reports.universities');
    Route::get('/subscriptions', 'ReportsController@subscriptions')->name('reports.subscriptions');
    Route::get('/majors', 'ReportsController@majors')->name('reports.majors');
    Route::get('/lessons', 'ReportsController@lessons')->name('reports.lessons');
    Route::get('/departments', 'ReportsController@departments')->name('reports.departments');
    Route::get('/courses', 'ReportsController@courses')->name('reports.courses');
    Route::get('/chapters', 'ReportsController@chapters')->name('reports.chapters');
	*/
    public function users(){
        return view('reports.users');
    }	
    public function universities(){
        return view('reports.universities');
    }
    public function subscriptions(){
        return view('reports.subscriptions');
    }
    public function majors(){
        return view('reports.majors');
    }
    public function lessons(){
        return view('reports.lessons');
    }
    public function departments(){
        return view('reports.departments');
    }
    public function chapters(){
        return view('reports.chapters');
    }
	
    public function financial(){
        return view('reports.financial');
    }

    public function marketing(){
        return view('reports.marketing');
    }

    public function technical(){
        return view('reports.technical');
    }

}
