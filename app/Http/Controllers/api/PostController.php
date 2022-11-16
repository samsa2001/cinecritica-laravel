<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = post::orderBy('popularidad','desc')->paginate(10);
        $posts = Post::orderBy('fecha','desc')->with('categoria')->paginate(10);
        return response()->json($posts);
    }
    public function indexEstrenos()
    {
        $posts = Post::where('categoria_id','4')->orderBy('fecha','desc')->paginate(10);
        return response()->json($posts);
    }
    public function indexTaquilla()
    {
        $posts = Post::where('categoria_id','7')->orderBy('fecha','desc')->paginate(10);
        return response()->json($posts);
    }
    public function indexCuriosidades()
    {
        $posts = Post::where('categoria_id','3')->orderBy('fecha','desc')->paginate(10);
        return response()->json($posts);
    }
    public function slug(Post $post)
    {
        return response()->json($post);
    }
}
