<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Index View
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * Edit a Post
     *
     * @param Post $post
     * @return void
     */
    public function edit(Post $post)
    {
        return view('blogs.edit', [
            'post' => $post
        ]);
    }

    /**
     * Post Detail
     *
     * @param Post $post
     * @return void
     */
    public function detail(Post $post)
    {
        return view('blogs.detail', [
            'post' => $post
        ]);
    }

    /**
     * Update a post
     *
     * @param Request $request
     * @param Post $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'min:6'],
            'content' => ['required', 'min:2']
        ])->validate();

        $post->update($validated);

        $request->session()->flash('status', 'Post Updated Successfully!');

        return redirect($post->getEditLink());
    }

    public function delete(Request $request, Post $post)
    {
        $post->delete();

        $request->session()->flash('status', 'Post Deleted Successfully!');

        return redirect(route('app.posts.index'));
    }
}
