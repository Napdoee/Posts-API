<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return PostDetailResource::collection($posts->loadMissing([
            'writer:id,username', 'comments:id,post_id,user_id,comments_content,created_at'
        ]));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);

        return new PostDetailResource($post->loadMissing([
            'writer:id,username', 'comments:id,post_id,user_id,comments_content,created_at'
        ]));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::with('writer:id,username')->create($request->all());

        return new PostDetailResource($post);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::with('writer:id,username')->findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post);
    }

    public function destroy($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);
        $post->delete();

        return new PostDetailResource($post);
    }
}
