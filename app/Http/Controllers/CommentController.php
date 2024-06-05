<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\CommentPosted;




class CommentController extends Controller
{

    public function index(){
        $comments = Comment::all();
        return response()->json($comments);
    }
    public function store(Request $request)
    {
        $request->validate(['text' => 'required']);
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
        ]);

        event(new CommentPosted($comment));

        return response()->json(['message' => 'Comment posted successfully.']);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
