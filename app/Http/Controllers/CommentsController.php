<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function comments(Request $request, $book_id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment();
        $comment->book_id = $book_id;
        $comment->user_id = Auth::user()->id;
        $comment->content = $request->content;

        $comment->save();

        return redirect('/book/' . $book_id)->with('success', 'Berhasil menambahkan komentar!');

    }
    public function update(Request $request, $comment_id)
    {
        // if (Auth::user()->id !== $comment->user_id) {
        //     abort(403);
        // }
        $request->validate([
            'content' => 'required|string',
        ]);
    
        $commentUpdated = Comment::findOrFail($comment_id);
        $commentUpdated->content = $request->content;
        $commentUpdated->save();
        
        return redirect()->back()->with('success', 'Comment updated!');
    }
}
