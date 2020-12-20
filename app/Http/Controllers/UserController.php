<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function __construct()
	{
	    // All methods except show require authorization - i.e a logged in user
	    $this->middleware('auth')->except([
	        'show'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show')->with([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Abort unless gate allows, 
        // pass the update ability from the PostPolicy, 
        //an instance of the post model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('update', $user), 403);

        // Returning success message to the view
        return view('user.edit')->with([
            'user' => $user,
            'message_success' => Session::get('message_success'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Abort unless gate allows, 
        // pass the update ability from the UserPolicy, 
        //an instance of the user model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('update', $user), 403);

        // Inserting validation
        $request->validate([
            'job' => 'required',
            'location' => 'required',
            'image' => 'mimes:bmp,gif,jpeg,jpg,png,svg',
        ]);

        // If an image has been sent
        if ($request->has('image')) {
            // Store image in varaible
            $path = $request->image;
            // Store image in the users directory, with the user_id as name  and convert to jpeg
            $path->storeAs(
                // Store image in the users directory within the public folder
                '/users',
                // Store the image as user_ID_img.jpg
                'user_' . $user->id . '_img' . '.jpg', 
                // Location of storage folder
                'public'
            );
        }

        // Updating the user's details
        $user->update([
            'job' => $request['job'],
            'location' => $request['location']
        ]);

        // Redirecting to the home page with the success message
        return redirect('/home')->with([
            'message_success' => 'Your profile was updated.'
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Abort unless gate allows, 
        // pass the delete ability from the UserPolicy, 
        //an instance of the user model,
        // If not an admin return 403 forbidden code
        abort_unless(Gate::allows('delete', $user), 403);
    }

    public function removeImage($user_id)
    {
        // Checking if file exists
        if(file_exists('storage/users/' . 'user_' . $user_id . '_img.jpg'))
            // Removing the file
            unlink('storage/users/' . 'user_' . $user_id . '_img.jpg');
        
        // Returning successful deletion message back to view
        return back()->with([
            'message_success' => 'The image as removed.'
        ]);
    }

}
