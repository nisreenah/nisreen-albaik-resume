<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Storage;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'en_comment' => 'required',
            'en_name' => 'required',
            'en_position' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/testimonials'), $filename);
            $input['image'] = $request->file('image')->getClientOriginalName();
        }

        Testimonial::create($input);
        Alert::success('The testimonials was created successfully!')->persistent('Close');
        return redirect()->route('testimonials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'en_comment' => 'required',
            'en_name' => 'required',
            'en_position' => 'required',
        ]);

        $input = $request->all();

        if ($request->get('image') != null) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/testimonials'), $filename);
            $input['image'] = $request->file('image')->getClientOriginalName();
        }else{
            unset( $input['image'] );
        }

        Testimonial::findOrFail($id)->update($input);
        Alert::success('The testimonial was updated successfully!')->persistent('Close');
        return redirect()->route('testimonials.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        Alert::success('The testimonial was deleted successfully!')->persistent('Close');
        return redirect()->route('testimonials.index');
    }
}
