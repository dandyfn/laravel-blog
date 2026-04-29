<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        
        $data = Post::where('user_id',$user->id)->orderBy('id','desc')->paginate(3);
        return view('member.blogs.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('member.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'thumbnail'=>'image|mimes:jpeg,jpg,png|max:10240'
        ],[
            'title.required' => 'judul wajib diisi',
            'content.required' => 'content wajib diisi',
            'thumbnail.image' => 'hanya gambar yang bisa',
            'thumbnail.mimes' => 'hanya format jpeg,jpg,png',
            'thumbnail.max' => 'maksimal 10mb'

        ]);

        if($request->hasFile('thumbnail')){
          
            $image = $request->file('thumbnail');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'));
            $image->move($destination_path,$image_name );
        }

        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'status'=>$request->status,
            'thumbnail'=>isset($image_name)?$image_name:null,
            'slug'=>$this->generateslug($request->title),
            'user_id'=>Auth::user()->id
        ];
        Post::create($data);
        return redirect()->route('member.blogs.index')->with('success','data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        // print_r($post);
        $data = $post;
        return view('member.blogs.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'thumbnail'=>'image|mimes:jpeg,jpg,png|max:10240'
        ],[
            'title.required' => 'judul wajib diisi',
            'content.required' => 'content wajib diisi',
            'thumbnail.image' => 'hanya gambar yang bisa',
            'thumbnail.mimes' => 'hanya format jpeg,jpg,png',
            'thumbnail.max' => 'maksimal 10mb'

        ]);

        if($request->hasFile('thumbnail')){
            if (isset($post->thumbnail) && file_exists(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')).'/'.$post->thumbnail)) {
                # code...
                unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')).'/'.$post->thumbnail);
            }
            $image = $request->file('thumbnail');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'));
            $image->move($destination_path,$image_name );
        }

        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'status'=>$request->status,
            'thumbnail'=>isset($image_name)?$image_name:$post->thumbnail,
            'slug'=>$this->generateslug($request->title,$post->id)
        ];
        Post::where('id',$post->id)->update($data);
        return redirect()->route('member.blogs.index')->with('success','data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
          if (isset($post->thumbnail) && file_exists(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')).'/'.$post->thumbnail)) {
                # code...
                unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')).'/'.$post->thumbnail);
            }
        Post::where('id',$post->id)->delete();
        return redirect()->route('member.blogs.index')->with('success','data berhasil dihapus');
    }

    private function generateslug ($title, $id=null){
        $slug = Str::slug($title);
        $count = Post::where('slug',$slug)->when($id, function($query,$id){
            return $query->where('id','!=',$id);
        })->count();

        if ($count > 0) {
            # code...
            $slug = $slug . "-" . ($count + 1);
        }
        return $slug;

    }
}
