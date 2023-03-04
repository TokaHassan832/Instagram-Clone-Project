<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $users=auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);
        return view('posts.index',[
            'posts'=>$posts
        ]);
    }

    public function show(Post $post){
        return view('posts.show',[
            'post'=>$post
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

     public  function store(Request $request){
        $Data=$request->validate([
            'caption'=>'required',
            'image'=>'required|image'
        ]);
        $imagePath=$request->file('image')->store('uploads','public');
         $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
         $image->save();
        auth()->user()->posts()->create([
            'caption'=>$Data['caption'],
            'image'=>$imagePath
        ]);
        return redirect('/profile/'.auth()->user()->id);

     }
}
