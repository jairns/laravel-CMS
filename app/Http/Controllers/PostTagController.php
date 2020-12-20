<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class postTagController extends Controller
{

    public function __construct()
	{
        // Unauthorized users can only filter posts by tags
	    $this->middleware('auth')->except([
	        'getFilterPosts'
	    ]);
	}

    public function getFilterPosts($tag_id) {
        // Creating new tag
        $tag = new Tag();
        // searching for tags with that tag_id and displaying them first with five per page
        $posts = $tag::findOrFail($tag_id)
        ->filteredPosts()
        ->paginate(5);

        // Storing filteredTag in variable
        $filteredTag = $tag::find($tag_id);

        // Returning the view where the filtered output should be displayed
        return view('post.index', [
            'posts' => $posts,
            'filteredTag' => $filteredTag
        ]);
    }

    public function assignTag($post_id, $tag_id){
        // Identifying the correct post and tag
        $post = Post::find($post_id);
        $tag = Tag::find($tag_id);
        // if the gate denies the ability of add_or_rm_post_tag
        if(Gate::denies('add_or_rm_post_tag', $post)) {
            // Deny access and display forbidden status code
            abort(403, 'Not authorized');
        }
        // Retrieving the tags function defined in the hobby model and attach the relevant tag id
        $post->tags()->attach($tag_id);
        // Returning success message to the view
        return back()->with([
            'message_success' => $tag->name . ' has been added to this post.'
        ]);
    }

    public function removeTag($post_id, $tag_id){
        // Identifying the correct post and tag
        $post = Post::find($post_id);
        $tag = Tag::find($tag_id);
        // if the gate denies the ability of add_or_rm_post_tag
        if(Gate::denies('add_or_rm_post_tag', $post)) {
            // Deny access and display forbidden status code
            abort(403, 'Not authorized');
        }
        // Retrieving the tags function defined in the hobby model and removing the relevant tag id
        $post->tags()->detach($tag_id);
        // Returning success message to the view
        return back()->with([
            'message_success' => $tag->name . ' has been removed from this post.'
        ]);
    }
}
