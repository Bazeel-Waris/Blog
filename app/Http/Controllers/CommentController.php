<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    // function for Deleting a user's own Comment for a specific Post
    public function deleteComment(Request $request)
    {
        $commentUser = auth()->user();
        $post = Post::find($request->post_id);
        $comment = Comment::find($request->id);

        if($commentUser->id == $comment->user_id && $post->id == $comment->post_id)
        {
            $comment->delete();

            return response()->json([
                'Status' => 'Comments Have been Deleted'
            ], 200);
        }
        else
        {
            return response()->json([
                'Status' => 'Unable to Delete Comment'
            ], 422);
        }
    }

    // function for Posting a Comment on a specific Post
    public function createComment(Request $request)
    {
        $user = auth()->user();
        $post = Post::find($request->post_id);

        $request->validate([
            'body' => 'required'
        ]);

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;

        $comment->save();
        return response()->json([
            'Status' => 'Comment Have been added Successfully!',
            'Comment' => $comment
        ], 200);
    }

    // function for Displaying all Comments of a Specific Post
    public function getPostComments(Request $request)
    {

        $post = Post::find($request->post_id);
        // return response()->json([
        //     'Post' => $post->id
        // ], 200);

        $comments = Comment::where('post_id', $post->id)->get();

        return response()->json([
            'Comments' => $comments
        ], 200);
        // if(empty($comments))
        // {
        //     return response()->json([
        //         'Comments' => $comments
        //     ], 200);
        // }
        // else
        // {
        //     return response()->json([
        //         'Status' => 'No Comments Available!'
        //     ], 400);
        // }

    }
}
