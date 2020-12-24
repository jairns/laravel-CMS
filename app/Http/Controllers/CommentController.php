<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct()
    {
        // All methods except index require authorization - i.e a logged in user
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
       // Inserting validation
        $request->validate([
            // To submit the form, a value is required
            'comment' => 'required',
        ]);
        // New commnet instace
        $comment = new Comment;
        // Get the user_id 
        $comment->user_id = auth()->id();
        // Get the post_id
        $comment->post_id = $post_id;
        // Get the value of the comment
        $comment->comment = $request->input('comment');
        // Save the comment 
        $comment->save();
        // Redirect user to specific post page after creation
        return back()->with([
            'message_success' => 'Comment added!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, $id)
    {

        // Find the id of the comment which is to be deleted
        $comment = Comment::findOrFail($id);
        // Delete the comment
        $comment->delete();
        
        // Abort unless gate allows, 
        // pass the update ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('delete', $comment), 403);

        // Return success message back to the view
        return back()->with([
            'message_success' => 'Comment was removed!'
        ]);
    }
}
