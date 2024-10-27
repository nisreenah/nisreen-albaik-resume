<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Auth;
use Alert;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'en_title' => 'required',
            'ar_title' => 'nullable',
            'year' => 'required',
            'image' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/courses'), $filename);
            $input['image'] = $request->file('image')->getClientOriginalName();
        }

        Course::create($input);
        Alert::success('The Course was created successfully!')->persistent('Close');
        return redirect()->route('courses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'en_title' => 'required',
            'ar_title' => 'nullable',
            'year' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/blogs'), $filename);
            $input['image'] = $request->file('image')->getClientOriginalName();
        } else {
            unset($input['image']);
        }

        $course = Course::findOrFail($id)->update($input);

        Alert::success('The course was updated successfully!')->persistent('Close');
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        Alert::success('The course was deleted successfully!')->persistent('Close');
        return redirect()->route('courses.index');
    }
}
