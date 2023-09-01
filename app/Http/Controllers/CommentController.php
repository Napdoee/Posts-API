<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            "post_id" => "required|exists:posts,id",
            "comments_content" => 'required',
        ]);

        $request['user_id'] = Auth::user()->id;
        $comment = Comment::create($request->all());

        return new CommentResource($comment->loadMissing(['comentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            "comments_content" => 'required',
        ]);        

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('comments_content'));

        return new CommentResource($comment->loadMissing(['comentator:id,username']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return new CommentResource($comment->loadMissing(['comentator:id,username']));   
    }
}
