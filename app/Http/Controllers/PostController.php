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
        $posts = $request->user()
            ->getPosts()
            ->with('author')
            ->orderBy('id', 'desc');

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
     * Create new post
     *
     * @param Request $request
     * @return void
     */
    public function new(Request $request)
    {
        return view('blogs.new');
    }

    public function create(Request $request)
    {
        $validated = $this->validation($request);
        $validated['author_id'] = $request->user()->id;

        $post = Post::create($validated);

        $request->session()->flash('status', 'Post Created Successfully!');

        return redirect($post->getDetailLink());
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
        $validated = $this->validation($request);

        $post->update($validated);

        $request->session()->flash('status', 'Post Updated Successfully!');

        return redirect($post->getEditLink());
    }

    /**
     * Delete a Post
     *
     * @param Request $request
     * @param Post $post
     * @return void
     */
    public function delete(Request $request, Post $post)
    {
        $post->delete();

        $request->session()->flash('status', 'Post Deleted Successfully!');

        return redirect(route('app.posts.index'));
    }

    /**
     * Validdtor
     *
     * @param Request $request
     * @return array
     */
    protected function validation(Request $request): array
    {
        return Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:6'],
            'content' => ['required', 'min:2', 'string']
        ])->validate();
    }
}
