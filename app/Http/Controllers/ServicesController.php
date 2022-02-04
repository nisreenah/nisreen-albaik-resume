<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Auth;
use Alert;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
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
            'en_title' => 'required',
            'en_details' => 'required',
            'icon' => 'required',
        ]);

        $input = $request->all();
        Service::create($input);
        Alert::success('The service was created successfully!')->persistent('Close');
        return redirect()->route('services.index');
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
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
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
            'en_title' => 'required',
            'en_details' => 'required',
            'icon' => 'required',
        ]);

        $input = $request->all();
        Service::findOrFail($id)->update($input);
        Alert::success('The service was updated successfully!')->persistent('Close');
        return redirect()->route('services.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        Alert::success('The service was deleted successfully!')->persistent('Close');
        return redirect()->route('services.index');
    }
}
