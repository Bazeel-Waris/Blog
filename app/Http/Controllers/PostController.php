<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function deletePost($id)
    {
        $user = auth()->user();
        $post = Post::find($id);
        // $post = $post->where('id', $id)->get();

        // Check if the post belongs to the authenticated user
        if ($post->user_id == $user->id) {
            $post->delete(); // Delete the post

            return response()->json(['message' => 'Post deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized to delete this post'], 403);
        }
    }

    public function editPost(Request $request)
    {

        $user = auth()->id();
        $post = Post::find($request->id);

        if($post->user_id == $user)
        {
            $validated = $request->validate([
                'title' => 'required',
                'body' => 'required'
            ]);

            $post->title = $request->title;
            $post->body = $request->body;

            $post->save();

            return response()->json([
                'Status' => 'Post Updated Successfully'
            ]);
        }
        else
        {
            return response()->json([
                'Status' => 'Post Cant be updated due to unauthorized access'
            ]);
        }

    }
    // Dislaying All posts of the Current User By the user Id
    public function displayUserPosts($id)
    {
        $currentUser = auth()->user();

        if($currentUser->id == $id)
        {
            $userPosts = Post::where('user_id', $currentUser->id)->get();
            return response()->json([
                'posts' => $userPosts
            ], 200);
        }

        return response()->json([
            'Message' => 'Unauthenticated User',
            'user_id' => $currentUser->id,
            'passed' => $id
        ]);

    }

    // Dislaying All posts Available on the Blog for comments
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            "All Posts" => $posts
        ], 200);
    }

    // This function is validating and storing the posts in Database
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
