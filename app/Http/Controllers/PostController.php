<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
	{
	    // All methods except index and show require authorization - i.e a logged in user
	    $this->middleware('auth')->except([
            'index', 
            'show'
            ]);
	}

    public function index()
    {
        //if a user submits a value within the search field store it within the search varaible
        $search = request()->query('search');

        // if $search exists
        if($search) {
            // Find posts which match the user input and store it within a variable
            $posts = post::where('title', 'LIKE', '%' . $search . '%')
            // Order by date of creation
            ->orderBy('created_at', 'DESC')
            // Paginate five per page
            ->paginate(5);
        } else {
            // Get all posts, order by date and assign five per page
            $posts = post::orderBy('created_at', 'DESC')->paginate(5);
        }
        // If no posts match the users search
        if($posts->count() === 0) {
            return view('post.index')->with([
                'posts' => $posts,
                // Return warning message
                'message_warning' => "No results found. Please search again or <a href='/post'>view all posts</a>"
            ]);
        } else {
            // If the user has not searched or their search has found results - display posts
            return view('post.index')->with([
                'posts' => $posts,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          // Inserting validation
          $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'content' => 'required|min:30',
            'image' => 'mimes:bmp,gif,jpeg,jpg,png,svg',
        ]);

        // Creating new instace of post model
        $post = new Post([
            'title' => $request['title'],
            'description' => $request['description'],   
            'content' => $request['content'],
            'user_id' => auth()->id()
        ]);
        // Saving new instance
        $post->save();
  
        // If an image has been sent
        if ($request->has('image')) {
                // Store image in varaible
                $path = $request->image;
                // Store image in the posts directory, with the post_id as name  and convert to jpeg
                $path->storeAs(
                // Store image in the posts directory within the public folder
                '/posts',
                // Store the image as post_ID_img.jpg
                'post_' . $post->id . '_img' . '.jpg', 
                // Location of storage folder
                'public'
            );
        }

        // Redirect user to specific post page after creation
        return redirect('/post/' . $post->id)->with([
            'message_success' => 'The post <b>' . $post->title . '</b> was created.<br>Now, Please add some tags!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Retreiving all the tags
        $tags = Tag::all();
        // Tags which are already applied to this post - using the eloquent relationship established in the post model
        $postsTags = $post->tags;
        // Using the diff method to find tags which arent currently applied
        $tagsAvailable = $tags->diff($postsTags);
        // Retreiving all comments
        $comments = Comment::all();
        // Returning to the front end
        return view('post.show')->with([
            'post' => $post,
            'tagsAvailable' => $tagsAvailable,
            'comments' => $comments,
            'message_success' => Session::get('message_success'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Abort unless gate allows, 
        // pass the update ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('update', $post), 403);
        return view('post.edit')->with([
            'post' => $post,
            'message_success' => Session::get('message_success'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Abort unless gate allows, 
        // pass the update ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('update', $post), 403);

        // Inserting validation
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'content' => 'required|min:30',
            'image' => 'mimes:bmp,gif,jpeg,jpg,png,svg',
        ]);

        // If an image has been sent
        if ($request->has('image')) {
            // Store image in varaible
            $path = $request->image;
            // Store image in the posts directory, with the post_id as name  and convert to jpeg
            $path->storeAs(
                // Store image in the posts directory within the public folder
                '/posts',
                // Store the image as post_ID_img.jpg
                'post_' . $post->id . '_img' . '.jpg', 
                // Location of storage folder
                'public'
            );
        }

        // Updating post
        $post->update([
            'title' => $request['title'],
            'description' => $request['description'],   
            'content' => $request['content']
        ]);

        // Calling the index method which will display the all posts view
        return $this->index()->with([
            'message_success' => 'The post <b>' . $post->title . '</b> was updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */


    public function destroy(Post $post)
    {
        // Abort unless gate allows, 
        // pass the delete ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('delete', $post), 403);
        // Storing the current title in a variable names 'oldTitle'
        $oldTitle = $post->title;   
        // Deleting the post
        $post->delete();
        // Redirect to index view and display successful deletion message
        return $this->index()->with([
            'message_success' => 'The post <b>' . $oldTitle . '</b> was deleted.'
        ]);
    }

    public function removeImage($post_id)
    {
        // Checking if file exists
        if(file_exists('storage/posts/' . 'post_' . $post_id . '_img.jpg'))
            // Removing the file
            unlink('storage/posts/' . 'post_' . $post_id . '_img.jpg');
        
        // Returning successful deletion message back to view
        return back()->with([
            'message_success' => 'The image has been removed.'
        ]);
    }

    // public function comment(Request $request, $post_id)
    // {
    //     // Inserting validation
    //     $request->validate([
    //         // To submit the form, a value is required
    //         'comment' => 'required',
    //     ]);
    //     // New commnet instace
    //     $comment = new Comment;
    //     // Get the user_id 
    //     $comment->user_id = auth()->id();
    //     // Get the post_id
    //     $comment->post_id = $post_id;
    //     // Get the value of the comment
    //     $comment->comment = $request->input('comment');
    //     // Save the comment 
    //     $comment->save();
    //     // Redirect user to specific post page after creation
    //     return redirect('/post/' . $post_id)->with([
    //         'message_success' => 'Comment added!',
    //     ]);
    // }

    // public function removeComment($id)
    // {
    //     // Find the id of the comment which is to be deleted
    //     $comment = Comment::findOrFail($id);
    //     // Delete the comment
    //     $comment->delete();

    //     // Return success message back to the view
    //     return back()->with([
    //         'message_success' => 'Comment was removed!'
    //     ]);
    // }

}
