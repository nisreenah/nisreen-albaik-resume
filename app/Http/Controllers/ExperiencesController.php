<?php

namespace App\Http\Controllers;

use App\Experience;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Storage;

class ExperiencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences = Experience::all();
        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.experiences.create');
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
            'en_position' => 'required',
            'en_company' => 'required',
            'en_details' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $input = $request->all();
        Experience::create($input);
        Alert::success('The experience was created successfully!')->persistent('Close');
        return redirect()->route('experiences.index');
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
        $experience = Experience::findOrFail($id);
        return view('admin.experiences.edit', compact('experience'));

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
            'en_position' => 'required',
            'en_company' => 'required',
            'en_details' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $input = $request->all();
        Experience::findOrFail($id)->update($input);
        Alert::success('The experience was updated successfully!')->persistent('Close');
        return redirect()->route('experiences.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Experience::findOrFail($id)->delete();
        Alert::success('The experience was deleted successfully!')->persistent('Close');
        return redirect()->route('experiences.index');
    }
}
