<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Selecting the Post model and storing in within a variable
        $posts = Post::select()
        // where the user_id is equal to the current logged in user_id
        ->where('user_id', auth()->id())
        // Order the posts by descending order
        ->orderBy('updated_at', 'DESC')
        // Get the posts
        ->get();
        // Returning the posts variable to the home view so it can be accessed
        return view('home')->with([
            'posts' => $posts
        ]);
    }
}
