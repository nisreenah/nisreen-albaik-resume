<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Alert;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        Comment::create($input);
        alert()->success('Your comment was added successfully!, and waiting for accept')->persistent('Close');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        Alert::success('The comment was deleted successfully!')->persistent('Close');
        return redirect()->route('comments.index');
    }

    public function activate($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->update(['status' => 'accepted']);

        alert()->success('The comment status was activated successfully!')->persistent('Close');
        return redirect()->route('comments.index');
    }

    public function deactivate($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->update(['status' => 'rejected']);

        alert()->success('The comment status was deactivated successfully!')->persistent('Close');
        return redirect()->route('comments.index');

    }

}
