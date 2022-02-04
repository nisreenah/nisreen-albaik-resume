<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.profile.create');
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
            'en_name' => 'required',
            'en_major' => 'required',
            'en_country' => 'required',
            'en_address' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'en_interest' => 'required',
            'en_bio' => 'required',
            'en_summary' => 'required',
            'en_title' => 'required',
            'CV'  => 'required',
        ]);

        $input = $request->all();
        Profile::create($input);

        if ($request->get('CV') != null) {
            $cv = $request->file('CV');

            $original_name = strtolower(trim($cv->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;

            $cv->move(public_path('images/cv'), $file_name);
            $input['CV'] = $file_name;
        }

        alert()->success('The profile was created successfully!')->persistent('Close');
        return redirect()->route('profile.index');
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
        $profile = Profile::findOrFail($id);
        return view('admin.profile.edit', compact('profile'));

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
            'en_name' => 'required',
            'en_major' => 'required',
            'en_country' => 'required',
            'en_address' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'en_interest' => 'required',
            'en_bio' => 'required',
            'en_summary' => 'required',
            'en_title' => 'required',
        ]);

        $input = $request->all();

        if ($request->get('CV') != null) {
            $cv = $request->file('CV');

            $original_name = strtolower(trim($cv->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;

            $cv->move(public_path('images/cv'), $file_name);
            $input['CV'] = $file_name;
        } else {
            unset($input['CV']);
        }

        $profile = Profile::findOrFail($id)->update($input);
        alert()->success('The profile was updated successfully!')->persistent('Close');
        return redirect()->route('profile.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Profile::findOrFail($id)->delete();
        alert()->success('The profile was deleted successfully!')->persistent('Close');
        return redirect()->route('profile.index');
    }
}
