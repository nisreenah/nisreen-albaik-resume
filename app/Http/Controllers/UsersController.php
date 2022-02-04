<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class UsersController extends Controller
{
    /** Display a listing of the resource.*/
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        return view('admin.users.create');
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($request->get('password'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //dd(md5_file($image));

            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            //dd($file_name);

            //$filename = date('Y-m-d-H-i-s') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $file_name);
            $input['image'] = $file_name;
        }

        User::create($input);
        alert()->success('The user was created successfully!')->persistent('Close');
        return redirect()->route('users.index');
    }

    /** Display the specified resource.*/
    public function show($id)
    {
        //
    }

    /** Show the form for editing the specified resource.*/
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /** Update the specified resource in storage.*/
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            //'password' => 'required|min:8',
        ]);

        $input = $request->all();

        if ($request->get('password') != null) {
            $input['password'] = Hash::make($request->get('password'));

        } else {
            unset($input['password']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //dd(md5_file($image));

            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            //dd($file_name);

            //$filename = date('Y-m-d-H-i-s') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $file_name);
            $input['image'] = $file_name;
        } else {
            unset($input['image']);
        }

        $user->update($input);

        alert()->success('The user was updated successfully!')->persistent('Close');
        return redirect()->route('users.index');

    }

    /** Remove the specified resource from storage.*/
    public function destroy(User $user)
    {
        $user->delete();
        alert()->success('The user was deleted successfully!')->persistent('Close');
        return redirect()->route('users.index');
    }
}
