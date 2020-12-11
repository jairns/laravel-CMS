<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
// Importing tag model
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Laravel' => 'primary', // blue
            'ASP.NET Core' => 'secondary', // grey
            'Express' => 'warning', // yellow
            'React' => 'success', // green
            'Spring' => 'light', // white grey
            'Vue' => 'info', // turquoise
            'Angular' => 'danger', // red
            'Ruby' => 'dark' // black-white
        ];

        foreach ($tags as $key => $value) {
            $tag = new Tag(
                [
                    'name' => $key,
                    'style' => $value
                ]
            );
            $tag->save();
        }

    }
}
