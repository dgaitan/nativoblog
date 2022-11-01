<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $context = [
            'user' => $request->user(),
            'posts_count' => $request->user()->postCount(),
            'bloggers_count' => $request->user()->bloggersCount(),
            'supervisors_count' => $request->user()->supervisorsCount()
        ];
        
        return view('home', $context);
    }
}
