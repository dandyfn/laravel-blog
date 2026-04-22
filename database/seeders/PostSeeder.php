<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $judul=[
            'judul 1',
             'judul 2',
              'judul 3',
               'judul 3',
        ];

        foreach ($judul as $j) {
            # code...
            $slug = Str::slug($j);
            $slugori = $slug;
            $count = 1;
            while (Post::where('slug',$slug)->exists()) {
                # code...
                $count++;
                $slug = $slugori."-".$count;
                
            }
            Post::create([
                'title'=> $j,
                'slug' => $slug,
                'description'=>'deskripsi j'.$j,
                'content'=>'konten'.$j,
                'status'=>'publish',
                'user_id'=>'1'

            ]);
        }
    }
}
