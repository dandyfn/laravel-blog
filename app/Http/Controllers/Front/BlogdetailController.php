<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogdetailController extends Controller
{
    //
    function detail($slug) {
        // echo $slug;
        $data = Post::where('status','publish')->where('slug',$slug)->firstOrFail();
        return view('components.front.blog-detail', compact('data'));
   
        }
}
