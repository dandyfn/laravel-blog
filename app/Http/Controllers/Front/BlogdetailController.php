<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;


class BlogdetailController extends Controller
{
    //
    function detail($slug) {
        // echo $slug;
        return view('components.front.blog-detail');
    }
}
