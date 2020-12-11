<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->times(10)->create()
        ->each(function($user){
            Post::factory()->times(2)->create(
                [
                    'user_id' => $user->id
                ]
            );
        });
    }
}