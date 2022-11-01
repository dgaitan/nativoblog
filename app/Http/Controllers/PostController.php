<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->getPosts()->with('author');

        if ($request->has('q')) {
            $posts->where(function($query) use ($request) {
                $query->where('title', 'like', "%$request->q%")
                    ->orWhere('content', 'like', "%$request->q%");
            }); 
        }

        return view('blogs.lists', [
            'posts' => $posts->paginate(20),
            'q' => $request->has('q') ? $request->q : ''
        ]);
    }
}
