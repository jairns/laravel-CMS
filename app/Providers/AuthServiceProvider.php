<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // defining the name of the gate and the closure function
        // Takes the current user and current post as argument 
        Gate::define('add_or_rm_post_tag', function($user, $post){
            // To add/remove tags, the current user_id must equal the posts user_id
           return $user->id === $post->user_id
            // Or is an admin
            || auth()->user()->role === 'admin';    
        });
    }
}
