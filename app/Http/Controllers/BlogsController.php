<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Auth;
use Alert;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'en_title' => 'required',
            'ar_title' => 'required',
            'en_details' => 'required',
            'ar_details' => 'required',
            'image' => 'required',
        ]);

        $input = $request->all();
        $input['posted_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/blogs'), $filename);
            $input['image'] = $request->file('image')->getClientOriginalName();
        }

        Blog::create($input);
        Alert::success('The blog was created successfully!')->persistent('Close');
        return redirect()->route('blogs.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'en_title' => 'required',
            'ar_title' => 'required',
            'en_details' => 'required',
            'ar_details' => 'required',
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

        $blog = Blog::findOrFail($id)->update($input);

        Alert::success('The blog was updated successfully!')->persistent('Close');
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        Alert::success('The blog was deleted successfully!')->persistent('Close');
        return redirect()->route('blogs.index');
    }
}
