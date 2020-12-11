<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tag.index')->with([
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
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
            'name' => 'required',
            'style' => 'required',
         ]);
        // Creating new instace of tag model
        $tag = new Tag([
            'name' => $request['name'],
            'style' => $request['style'],  
        ]);
        // Saving new instance
        $tag->save();
        // Calling the index method which will display the all tags view
        return $this->index()->with([
            'message_success' => 'The tag <b>' . $tag->name . '</b> was created.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tag.edit')->with([
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // Inserting validation
        $request->validate([
            'name' => 'required',
            'style' => 'required',
        ]);
        // Updating tag
        $tag->update([
            'name' => $request['name'],
            'style' => $request['style'],   
        ]);
        
        // Calling the index method which will display the all tags view
        return $this->index()->with([
            'message_success' => 'The tag <b>' . $tag->name . '</b> was updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        // Storing the current title in a variable names 'oldName'
        $oldName = $tag->name;   
        // Deleting the tag
        $tag->delete();
        // Redirect to index view and display successful deletion message
        return $this->index()->with([
            'message_success' => 'The tag <b>' . $oldName . '</b> was deleted.'
        ]);
    }
}
