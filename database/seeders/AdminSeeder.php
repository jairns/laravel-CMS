<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create new user instance and assign it to a varaible
        $admin = new User([
            // Admin users name is admin
            'name' => 'admin',
            // Used my student email
            'email' => 'b00356310@studentmail.uws.ac.uk',
            // Email is currently verified
            'email_verified_at' => now(),
            // Storing the password as a hashed version of the below value
            'password' => Hash::make('AdminPassword164'),
            'remember_token' => Str::random(10),
            // Specifying the user's role
            'role' => 'admin'
        ]);
        // Saving the admin user within the database
        $admin->save();
    }
}
