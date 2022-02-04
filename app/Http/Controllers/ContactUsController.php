<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactUsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_us = Contact::orderBy('created_at','desc')->get();
        return view('admin.contact-us.index', compact('contact_us'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact_us = Contact::findOrFail($id);
        $contact_us->update(['is_seen' => '1']);
        return view('admin.contact-us.show', compact('contact_us'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        Alert::success('The message was deleted successfully!')->persistent('Close');
        return redirect()->route('contact-us.index');
    }

}
