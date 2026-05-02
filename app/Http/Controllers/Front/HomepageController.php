<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;


class HomepageController extends Controller
{
    //
    public function index(){
        $lastData = $this->lastData();
      
     
        $data = Post::where('status','publish')->orderBy('id','desc')->paginate(2);
        return view('components.front.home-page',compact('data','lastData'));
    }

    public function lastData(){
        $data = Post::where('status','publish')->orderBy('id','desc')->latest()->first();
        return $data;
    }
}
