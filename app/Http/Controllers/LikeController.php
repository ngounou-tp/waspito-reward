<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\PostLiked;


class LikeController extends Controller
{
    public function store(Comment $comment)
    {
        $like = Like::create([
            'user_id' => auth()->id(),
            'comment_id' => $comment->id,
        ]);

        event(new PostLiked($like));

        return response()->json(['message' => 'Comment liked successfully.']);
    }

    public function destroy(Comment $comment)
    {
        $like = Like::where('user_id', auth()->id())->where('comment_id', $comment->id)->first();
        $like->delete();

        return response()->json(['message' => 'Like removed successfully.']);
    }
}
