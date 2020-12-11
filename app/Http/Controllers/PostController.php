<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('post.index')->with([
            'posts' => $posts
        ]);
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
        ]);
        // Creating new instace of post model
        $post = new Post([
            'title' => $request['title'],
            'description' => $request['description'],   
            'content' => $request['content']
        ]);
        // Saving new instance
        $post->save();
        // Calling the index method which will display the all posts view
        return $this->index()->with([
            'message_success' => 'The post <b>' . $post->title . '</b> was created.'
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
        return view('post.show')->with([
            'post' => $post
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
        return view('post.edit')->with([
            'post' => $post
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
        // Inserting validation
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'content' => 'required|min:30',
        ]);
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
        // Storing the current title in a variable names 'oldTitle'
        $oldTitle = $post->title;   
        // Deleting the post
        $post->delete();
        // Redirect to index view and display successful deletion message
        return $this->index()->with([
            'message_success' => 'The post <b>' . $oldTitle . '</b> was deleted.'
        ]);
    }
}
