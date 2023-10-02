<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function displayUserPost($id)
    {
        $currentUser = auth()->user();

        if($currentUser->id == $id)
        {
            $userPosts = Post::where('user_id', $currentUser->id)->get();
            return response()->json([
                'posts' => $userPosts
            ], 200);
        }

    }

    public function index()
    {
        $posts = Post::all();

        return response()->json([
            "All Posts" => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->id();

        $post->save();

        return response()->json(['post' => $post], 200);
    }
}
