<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Storage;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.skills.create');
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
            'percentage' => 'required',
            'name' => 'required',
            'summary' => 'required',
        ]);

        $input = $request->all();
        Skill::create($input);
        Alert::success('The skill was created successfully!')->persistent('Close');
        return redirect()->route('skills.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skills.edit', compact('skill'));

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
            'percentage' => 'required',
            'name' => 'required',
            'summary' => 'required',
        ]);

        $input = $request->all();
        Skill::findOrFail($id)->update($input);
        Alert::success('The skill was updated successfully!')->persistent('Close');
        return redirect()->route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Skill::findOrFail($id)->delete();
        Alert::success('The skill was deleted successfully!')->persistent('Close');
        return redirect()->route('skills.index');
    }
}
