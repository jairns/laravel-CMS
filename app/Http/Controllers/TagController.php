<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class TagController extends Controller
{

    public function __construct()
    {
        // All methods except index require authorization - i.e a logged in user
        $this->middleware('auth')->except([
            'index'
        ]);
        
        // Adding admin middleware as the admin can use all the methods
        $this->middleware('admin')->except([
            'index'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(Gate::allows('view', $tag), 403);
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
        // abort_unless(Gate::allows('create', $tag), 403);
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

        // abort_unless(Gate::allows('create', $tag), 403);
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
        // Abort unless gate allows, 
        // pass the update ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        // abort_unless(Gate::allows('update', $tag), 403);

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
        // Abort unless gate allows, 
        // pass the update ability from the TagPolicy, 
        //an instance of the tags model,
        // If not an admin return 403 forbidden code
        // abort_unless(Gate::allows('update', $tag), 403);

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
        // Abort unless gate allows, 
        // pass the delete ability from the TagPolicy, 
        //an instance of the tag model,
        // If not an admin return 403 forbidden code
        // abort_unless(Gate::allows('delete', $tag), 403);

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
